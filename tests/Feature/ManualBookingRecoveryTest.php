<?php

namespace Tests\Feature;

use App\Http\Controllers\WebHook\WebHookController;
use App\Models\BookingDetail;
use App\Models\UserReservation;
use App\Services\ManualBookingRecovery;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ManualBookingRecoveryTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config(['database.default' => 'manual_recovery_test',
            'database.connections.manual_recovery_test' => ['driver' => 'sqlite', 'database' => ':memory:', 'prefix' => ''],
            'services.channexpro.events_enabled' => false]);
        DB::purge('manual_recovery_test');
        $this->assertSame(':memory:', DB::connection()->getDatabaseName());
        Schema::create('guest_users', function (Blueprint $t) { $t->id(); $t->string('email'); $t->softDeletes(); });
        Schema::create('apartments', function (Blueprint $t) { $t->id(); $t->softDeletes(); });
        Schema::create('extras', function (Blueprint $t) { $t->id(); $t->integer('user_reservation_id')->nullable(); $t->integer('reservation_id')->nullable(); $t->softDeletes(); });
        Schema::create('system_settings', function (Blueprint $t) { $t->id(); });
        Schema::create('user_reservations', function (Blueprint $t) {
            $t->id(); $t->integer('guest_user_id'); $t->integer('property_id');
            foreach (['currency', 'currency_code', 'status', 'coupon', 'pricing_snapshot', 'checkin', 'checkout'] as $f) { $t->text($f)->nullable(); }
            foreach (['total', 'original_amount', 'exchange_rate', 'caution_fee'] as $f) { $t->decimal($f, 18, 6)->nullable(); }
            $t->boolean('checked')->default(false); $t->boolean('is_cancelled')->default(false);
            $t->integer('length_of_stay')->nullable(); $t->timestamps(); $t->softDeletes();
        });
        Schema::create('booking_details', function (Blueprint $t) {
            $t->id(); $t->integer('property_id'); $t->integer('apartment_id'); $t->integer('quantity');
            $t->decimal('price', 18, 2); $t->decimal('total', 18, 2); $t->decimal('sale_price', 18, 2)->nullable();
            $t->string('currency_code'); $t->text('pricing_snapshot'); $t->string('checkin'); $t->string('checkout');
            $t->timestamps(); $t->softDeletes();
        });
        Schema::create('reservations', function (Blueprint $t) {
            $t->id(); $t->integer('user_reservation_id'); $t->integer('apartment_id'); $t->integer('property_id');
            $t->integer('quantity'); $t->bigInteger('price'); $t->bigInteger('sale_price')->nullable();
            $t->string('currency'); $t->string('currency_code'); $t->decimal('rate', 18, 6);
            $t->text('pricing_snapshot'); $t->string('checkin'); $t->string('checkout'); $t->integer('length_of_stay');
            $t->boolean('is_active')->default(true); $t->timestamps(); $t->softDeletes();
        });
        DB::table('guest_users')->insert(['id' => 1, 'email' => 'guest@example.test']);
        DB::table('apartments')->insert(['id' => 58]);
        $snapshot = ['currency_code' => 'USD', 'currency_symbol' => '$', 'exchange_rate' => 1, 'nights' => 3,
            'regular_nightly' => 319, 'regular_total' => 957, 'average_nightly' => 319, 'accommodation_total' => 957,
            'nightly_breakdown' => [['date' => '2026-10-23', 'base_price' => 319, 'price' => 319]]];
        DB::table('user_reservations')->insert(['id' => 1, 'guest_user_id' => 1, 'property_id' => 20, 'currency' => '$',
            'currency_code' => 'USD', 'exchange_rate' => 1, 'total' => 957, 'original_amount' => 957,
            'pricing_snapshot' => json_encode($snapshot)]);
        foreach ([1531, 1532] as $id) {
            DB::table('booking_details')->insert(['id' => $id, 'property_id' => 20, 'apartment_id' => 58,
                'quantity' => 1, 'price' => 319, 'total' => 957, 'currency_code' => 'USD',
                'pricing_snapshot' => json_encode($snapshot), 'checkin' => '2026-10-23', 'checkout' => '2026-10-26']);
        }
    }

    public function test_recovery_reuses_header_is_idempotent_and_preserves_original_quote(): void
    {
        $service = new ManualBookingRecovery;
        $service->prepare(1, 1532, [1531, 1532], 1331.83);
        $header = $service->complete(1);
        $service->complete(1);
        $service->prepare(1, 1532, [1531, 1532], 1331.83);
        $this->assertSame(1, UserReservation::count());
        $this->assertSame(1, DB::table('reservations')->count());
        $this->assertSame('NGN', $header->currency_code);
        $this->assertEquals(0, $header->checked, 'Recovery must not mark the guest as already checked in.');
        $this->assertEquals(1274561.31, $header->total);
        $this->assertEquals(424853.77, data_get($header->pricing_snapshot, 'average_nightly'));
        $this->assertEquals(957, data_get($header->pricing_snapshot, 'manual_recovery.source_header.total'));
        $this->assertSame('USD', data_get($header->pricing_snapshot, 'manual_recovery.source_header.currency_code'));
        $this->assertSame('deferred', data_get($header->pricing_snapshot, 'manual_recovery.gateway_verification'));
        $this->assertNull(data_get($header->pricing_snapshot, 'manual_recovery.gateway_reference'));
        $this->assertSame(2, BookingDetail::count());
    }

    public function test_only_recorded_retry_carts_for_the_same_guest_are_intercepted(): void
    {
        $service = new ManualBookingRecovery;
        $this->assertNull($service->matchingCallback(['email' => 'guest@example.test'], [1532]));
        $service->prepare(1, 1532, [1531, 1532], 1331.83);
        $this->assertNotNull($service->matchingCallback(['email' => 'GUEST@example.test'], ['1532']));
        $this->assertNull($service->matchingCallback(['email' => 'other@example.test'], [1532]));
        $this->assertNull($service->matchingCallback(['email' => 'guest@example.test'], [999]));
        $this->assertNull($service->matchingCallback(['email' => 'guest@example.test'], [1532, 999]));
        Mail::fake();
        $response = (new WebHookController)->payment(Request::create('/webhook/payment', 'POST', [
            'event' => 'charge.success', 'data' => ['reference' => 'deferred-reference', 'amount' => 95700,
                'currency' => 'USD', 'metadata' => ['custom_fields' => [['booking' => [
                    'email' => 'guest@example.test', 'booking_ids' => [1532],
                ]]]]],
        ]));
        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('manual_recovery_recorded', $response->getData()->status);
        $this->assertSame(0, DB::table('reservations')->count());
        $this->assertSame(1, UserReservation::count());
        Mail::assertNothingSent();
    }

    public function test_a_conflict_aborts_without_changing_currency_or_creating_a_line(): void
    {
        $service = new ManualBookingRecovery;
        $service->prepare(1, 1532, [1531, 1532], 1331.83);
        DB::table('reservations')->insert(['user_reservation_id' => 2, 'apartment_id' => 58, 'property_id' => 20,
            'quantity' => 1, 'price' => 319, 'currency' => '$', 'currency_code' => 'USD', 'rate' => 1,
            'pricing_snapshot' => '{}', 'checkin' => '2026-10-24', 'checkout' => '2026-10-27', 'length_of_stay' => 3]);
        try {
            $service->complete(1);
            $this->fail('Conflicting recovery should fail.');
        } catch (\RuntimeException $e) {
            $this->assertStringContainsString('no longer available', $e->getMessage());
        }
        $this->assertSame('USD', UserReservation::find(1)->currency_code);
        $this->assertSame(0, DB::table('reservations')->where('user_reservation_id', 1)->count());
    }

    public function test_receipt_php_blocks_compile_on_the_installed_blade_version(): void
    {
        $compiled = app('blade.compiler')->compileString(file_get_contents(resource_path('views/emails/receipt/index.blade.php')));
        $this->assertStringNotContainsString('@php', $compiled);
        $this->assertStringContainsString('$receiptDecimals = data_get', $compiled);
        $this->assertStringContainsString('number_format($user_reservation->total, $receiptDecimals)', $compiled);
    }

    public function test_currency_correction_updates_existing_records_and_retains_the_naira_audit(): void
    {
        $service = new ManualBookingRecovery;
        $service->prepare(1, 1532, [1531, 1532], 1331.83);
        $service->complete(1);
        $lineId = DB::table('reservations')->value('id');
        $header = $service->restoreOriginalCurrency(1);
        $this->assertSame('USD', $header->currency_code);
        $this->assertSame('$', $header->currency);
        $this->assertEquals(957, $header->total);
        $this->assertEquals(1, $header->exchange_rate);
        $this->assertEquals(0, $header->checked);
        $line = $header->reservations()->first();
        $this->assertSame($lineId, $line->id);
        $this->assertSame('USD', $line->currency_code);
        $this->assertEquals(319, $line->price);
        $this->assertEquals(319, data_get($line->pricing_snapshot, 'average_nightly'));
        $this->assertEquals(1274561.31, data_get($header->pricing_snapshot, 'manual_recovery.currency_correction.previous_header.total'));
        $this->assertSame('NGN', data_get($header->pricing_snapshot, 'manual_recovery.currency_correction.previous_snapshot.currency_code'));
        $this->assertSame('deferred', data_get($header->pricing_snapshot, 'manual_recovery.gateway_verification'));
        $service->restoreOriginalCurrency(1);
        $service->complete(1);
        $this->assertSame(1, UserReservation::count());
        $this->assertSame(1, DB::table('reservations')->count());
        $this->assertSame(1, $service->matchingCallback(['email' => 'guest@example.test'], [1532])->id);
    }

    public function test_currency_correction_does_not_overwrite_an_edited_total(): void
    {
        $service = new ManualBookingRecovery;
        $service->prepare(1, 1532, [1531, 1532], 1331.83);
        $service->complete(1);
        DB::table('user_reservations')->where('id', 1)->update(['total' => 100]);
        try {
            $service->restoreOriginalCurrency(1);
            $this->fail('A changed booking must require inspection.');
        } catch (\RuntimeException $e) {
            $this->assertStringContainsString('changed', $e->getMessage());
        }
        $this->assertEquals(100, UserReservation::find(1)->total);
        $this->assertSame('NGN', UserReservation::find(1)->currency_code);
    }
}
