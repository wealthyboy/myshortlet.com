<?php

namespace Tests\Feature;

use App\Jobs\NotifyChannexProReservationEvent;
use App\Models\Property;
use App\Models\Reservation;
use App\Models\UserReservation;
use App\Services\ChannexPro\AriExportService;
use Carbon\Carbon;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Tests\TestCase;

class ChannexProReservationReceiverTest extends TestCase
{
    private string $booking;

    protected function setUp(): void
    {
        parent::setUp();
        config(['database.default' => 'ota_receiver_test',
            'database.connections.ota_receiver_test' => ['driver' => 'sqlite', 'database' => ':memory:', 'prefix' => ''],
            'services.channexpro.shared_token' => 'cp-test', 'services.channexpro.reservations_enabled' => true,
            'services.channexpro.events_enabled' => true]);
        DB::purge('ota_receiver_test');
        $this->assertSame(':memory:', DB::connection()->getDatabaseName());
        Bus::fake(); Mail::fake();
        Schema::create('system_settings', function (Blueprint $t) { $t->id(); });
        Schema::create('properties', function (Blueprint $t) {
            $t->id(); $t->boolean('allow')->default(true); $t->softDeletes();
        });
        Schema::create('apartments', function (Blueprint $t) {
            $t->id(); $t->integer('property_id'); $t->integer('quantity')->default(1); $t->string('name')->default('Apartment');
            $t->decimal('price', 16, 2)->default(100); $t->boolean('allow')->default(true); $t->softDeletes();
        });
        Schema::create('guest_users', function (Blueprint $t) {
            $t->id(); $t->string('name'); $t->string('last_name'); $t->string('email');
            $t->string('phone_number')->nullable(); $t->timestamps(); $t->softDeletes();
        });
        Schema::create('user_reservations', function (Blueprint $t) {
            $t->id(); $t->integer('property_id'); $t->integer('guest_user_id')->nullable();
            foreach (['invoice', 'coming_from', 'payment_type', 'ota_name', 'currency', 'currency_code',
                'external_id', 'status', 'checkin', 'checkout', 'pricing_snapshot', 'channex_last_revision_id', 'channex_last_revision_at'] as $field) {
                $t->text($field)->nullable();
            }
            $t->decimal('total', 16, 2)->nullable(); $t->decimal('original_amount', 16, 2)->nullable();
            $t->boolean('is_cancelled')->default(false); $t->boolean('checked')->default(false); $t->timestamps(); $t->softDeletes();
        });
        Schema::create('reservations', function (Blueprint $t) {
            $t->id(); $t->integer('user_reservation_id'); $t->integer('apartment_id'); $t->integer('property_id');
            $t->integer('quantity'); $t->decimal('price', 16, 2); $t->string('currency'); $t->string('currency_code');
            $t->decimal('rate', 16, 6); $t->text('pricing_snapshot'); $t->string('checkin'); $t->string('checkout');
            $t->integer('length_of_stay'); $t->boolean('is_blocked')->default(false); $t->timestamps(); $t->softDeletes();
        });
        Schema::create('apartment_daily_rates', function (Blueprint $t) {
            $t->id(); $t->integer('apartment_id'); $t->integer('channex_rate_plan_id')->nullable(); $t->date('date');
            $t->timestamps(); $t->softDeletes();
        });
        Schema::create('channex_rate_plans', function (Blueprint $t) {
            $t->id(); $t->integer('apartment_id'); $t->boolean('is_active')->default(true);
            $t->boolean('is_default')->default(true); $t->string('name'); $t->softDeletes();
        });
        require_once database_path('migrations/2026_10_23_150000_create_channexpro_booking_receipts_table.php');
        (new \CreateChannexproBookingReceiptsTable)->up();
        DB::table('properties')->insert([['id' => 20, 'allow' => true], ['id' => 21, 'allow' => true]]);
        DB::table('apartments')->insert([['id' => 58, 'property_id' => 20], ['id' => 59, 'property_id' => 21]]);
        $this->booking = (string) Str::uuid();
    }

    private function payload(array $changes = []): array
    {
        return array_replace([
            'schema' => 'channexpro.channel-reservation.v1', 'revision_id' => (string) Str::uuid(),
            'revision_at' => '2026-10-23T15:00:00.123456Z', 'booking_id' => $this->booking,
            'property_id' => '20', 'reference' => 'EXP-123', 'ota_name' => 'Expedia', 'status' => 'new',
            'currency' => 'USD', 'amount' => 200, 'check_in' => '2026-11-01', 'check_out' => '2026-11-03',
            'guest' => ['first_name' => 'Test', 'last_name' => 'Guest', 'email' => 'guest@example.test', 'phone' => null],
            'rooms' => [['room_type_id' => '58', 'rate_plan_id' => 'standard:58', 'quantity' => 1,
                'amount' => 200, 'check_in' => '2026-11-01', 'check_out' => '2026-11-03']],
        ], $changes);
    }

    private function receive(array $data)
    {
        return $this->postJson('/api/channexpro/reservations', $data, ['Authorization' => 'Bearer cp-test']);
    }

    private function availability(string $date): int
    {
        $data = app(AriExportService::class)->export(Property::findOrFail(20), Carbon::parse($date), Carbon::parse($date));
        return (int) $data['availability'][0]['availability'];
    }

    public function test_confirmed_booking_blocks_nights_not_checkout_and_does_not_fake_a_payment(): void
    {
        $data = $this->payload();
        $this->receive($data)->assertOk()->assertJson(['received' => true, 'revision_id' => $data['revision_id'], 'stale' => false])
            ->assertJsonPath('affected.0.to', '2026-11-02');
        $this->assertSame(1, UserReservation::count()); $this->assertSame(1, Reservation::count());
        $this->assertEquals(0, UserReservation::first()->checked);
        $this->assertSame('USD', UserReservation::first()->currency_code);
        $this->assertEquals(200, UserReservation::first()->total);
        $this->assertEquals(100, Reservation::first()->price);
        $this->assertSame(0, $this->availability('2026-11-01'));
        $this->assertSame(0, $this->availability('2026-11-02'));
        $this->assertSame(1, $this->availability('2026-11-03'));
        Bus::assertNotDispatched(NotifyChannexProReservationEvent::class); Mail::assertNothingSent();
    }

    public function test_duplicate_revision_returns_same_receipt_and_never_creates_a_second_stay(): void
    {
        $data = $this->payload(); $first = $this->receive($data)->assertOk()->json();
        $this->assertSame($first, $this->receive($data)->assertOk()->json());
        $this->assertSame(1, UserReservation::count()); $this->assertSame(1, Reservation::count());
        $this->assertSame(1, DB::table('channexpro_booking_receipts')->count());
    }

    public function test_revision_id_cannot_be_reused_to_mutate_an_existing_booking(): void
    {
        $data = $this->payload(); $this->receive($data)->assertOk();
        $data['amount'] = 999; $this->receive($data)->assertStatus(409);
        $this->assertEquals(200, UserReservation::first()->total);
    }

    public function test_date_modification_replaces_only_this_booking_and_preserves_both_ari_windows_for_retries(): void
    {
        $this->receive($this->payload())->assertOk();
        $data = $this->payload(['status' => 'modified', 'revision_at' => '2026-10-23T16:00:00Z',
            'check_in' => '2026-11-05', 'check_out' => '2026-11-07',
            'rooms' => [['room_type_id' => '58', 'rate_plan_id' => 'standard:58', 'quantity' => 1,
                'amount' => 200, 'check_in' => '2026-11-05', 'check_out' => '2026-11-07']]]);
        $result = $this->receive($data)->assertOk()->json();
        $this->assertCount(2, $result['affected']);
        $this->assertSame('2026-11-01', $result['affected'][0]['from']);
        $this->assertSame('2026-11-05', $result['affected'][1]['from']);
        $this->assertSame($result, $this->receive($data)->assertOk()->json());
        $this->assertSame(1, UserReservation::count()); $this->assertSame(1, Reservation::count());
        $this->assertSame(1, $this->availability('2026-11-01')); $this->assertSame(0, $this->availability('2026-11-05'));
    }

    public function test_cancellation_releases_only_its_own_room_lines_not_another_confirmed_booking(): void
    {
        $this->receive($this->payload())->assertOk();
        $second = $this->payload(['booking_id' => (string) Str::uuid()]); $this->receive($second)->assertOk();
        $cancel = $this->payload(['status' => 'cancelled', 'rooms' => [], 'revision_at' => '2026-10-23T16:00:00Z']);
        $result = $this->receive($cancel)->assertOk()->json();
        $this->assertSame('2026-11-02', $result['affected'][0]['to']);
        $this->assertSame(2, UserReservation::count()); $this->assertSame(1, Reservation::count());
        $this->assertEquals(1, UserReservation::where('external_id', $this->booking)->first()->is_cancelled);
        $this->assertSame(0, $this->availability('2026-11-01'));
        $second['revision_id'] = (string) Str::uuid(); $second['revision_at'] = '2026-10-23T16:00:00Z';
        $second['status'] = 'cancelled'; $second['rooms'] = [];
        $this->receive($second)->assertOk();
        $this->assertSame(1, $this->availability('2026-11-01'));
    }

    public function test_late_old_revision_cannot_resurrect_a_cancelled_booking_even_with_microsecond_timestamps(): void
    {
        $this->receive($this->payload(['status' => 'cancelled', 'revision_at' => '2026-10-23T15:00:00.923456Z', 'rooms' => []]))->assertOk();
        $this->receive($this->payload())->assertOk()->assertJson(['stale' => true, 'affected' => []]);
        $this->assertSame(0, Reservation::count()); $this->assertSame('cancelled', UserReservation::first()->status);
    }

    public function test_cross_property_room_is_rejected_before_creating_any_record(): void
    {
        $data = $this->payload(); $data['rooms'][0]['room_type_id'] = '59';
        $this->receive($data)->assertStatus(422);
        $this->assertSame(0, Reservation::count()); $this->assertSame(0, UserReservation::count());
        $this->assertSame(0, DB::table('channexpro_booking_receipts')->count());
    }

    public function test_missing_and_wrong_tokens_are_rejected_without_writing(): void
    {
        $this->postJson('/api/channexpro/reservations', $this->payload())->assertStatus(401);
        $this->postJson('/api/channexpro/reservations', $this->payload(), ['Authorization' => 'Bearer wrong'])->assertStatus(401);
        $this->assertSame(0, UserReservation::count());
    }

    public function test_missing_server_token_or_disabled_receiver_fail_closed(): void
    {
        config(['services.channexpro.shared_token' => '']); $this->receive($this->payload())->assertStatus(503);
        config(['services.channexpro.shared_token' => 'cp-test', 'services.channexpro.reservations_enabled' => false]);
        $this->receive($this->payload())->assertStatus(503); $this->assertSame(0, UserReservation::count());
    }

    public function test_invalid_dates_are_rejected_and_cancellation_of_absent_booking_is_idempotent(): void
    {
        $data = $this->payload(); $data['rooms'][0]['check_out'] = $data['rooms'][0]['check_in'];
        $this->receive($data)->assertStatus(422);
        $cancel = $this->payload(['status' => 'cancelled', 'rooms' => []]);
        $this->receive($cancel)->assertOk(); $this->receive($cancel)->assertOk();
        $this->assertSame(0, Reservation::count()); $this->assertSame(1, UserReservation::count());
    }

    public function test_existing_legacy_ota_booking_is_updated_in_place_not_duplicated(): void
    {
        $header = UserReservation::create(['property_id' => 20, 'external_id' => $this->booking, 'status' => 'confirmed']);
        $this->receive($this->payload())->assertOk();
        $this->assertSame(1, UserReservation::count()); $this->assertSame($header->id, Reservation::first()->user_reservation_id);
    }
}
