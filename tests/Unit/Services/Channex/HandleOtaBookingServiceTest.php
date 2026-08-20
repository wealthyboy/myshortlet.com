<?php

namespace Tests\Unit\Services\Channex;

use App\Models\Apartment;
use App\Models\ChannexCertificationLog;
use App\Models\GuestUser;
use App\Models\Property;
use App\Models\Reservation;
use App\Models\UserReservation;
use App\Services\Channex\BookingRevisionService;
use App\Services\Channex\CertificationLogService;
use App\Services\Channex\HandleOtaBookingService;
use App\Services\Channex\InventorySyncService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Mockery;
use Tests\TestCase;

class HandleOtaBookingServiceTest extends TestCase
{
    public function test_one_feed_pull_processes_and_acknowledges_each_revision_once(): void
    {
        $revisions = Mockery::mock(BookingRevisionService::class);
        $revisions->shouldReceive('fetchFeed')
            ->once()
            ->with('property-1')
            ->andReturn([
                'data' => [
                    [
                        'id' => 'revision-1',
                        'attributes' => [
                            'booking_id' => 'booking-1',
                            'property_id' => 'property-1',
                            'status' => 'new',
                        ],
                    ],
                    [
                        'id' => 'revision-2',
                        'attributes' => [
                            'booking_id' => 'booking-2',
                            'property_id' => 'property-1',
                            'status' => 'cancelled',
                        ],
                    ],
                ],
            ]);
        $this->app->instance(BookingRevisionService::class, $revisions);

        $service = new RecordingFeedHandleOtaBookingService();
        $count = $service->processFeed([
            'property_id' => 'property-1',
            // Even if send_data=true supplies IDs, the feed remains the only
            // source used by the worker.
            'booking_revision_id' => 'webhook-revision-id',
            'booking_id' => 'webhook-booking-id',
        ]);

        $this->assertSame(2, $count);
        $this->assertSame([
            ['action' => 'upsert', 'revision_id' => 'revision-1', 'booking_id' => 'booking-1'],
            ['action' => 'cancel', 'revision_id' => 'revision-2', 'booking_id' => 'booking-2'],
        ], $service->processed);
        $this->assertSame(['revision-1', 'revision-2'], $service->acknowledged);
        $this->assertFalse(method_exists(BookingRevisionService::class, 'fetch'));
    }

    public function test_empty_feed_is_a_successful_no_op(): void
    {
        $revisions = Mockery::mock(BookingRevisionService::class);
        $revisions->shouldReceive('fetchFeed')
            ->once()
            ->with('property-1')
            ->andReturn(['data' => []]);
        $this->app->instance(BookingRevisionService::class, $revisions);

        $service = new RecordingFeedHandleOtaBookingService();

        $this->assertSame(0, $service->processFeed(['property_id' => 'property-1']));
        $this->assertSame([], $service->processed);
        $this->assertSame([], $service->acknowledged);
    }

    public function test_missing_property_id_is_rejected_before_feed_access(): void
    {
        $revisions = Mockery::mock(BookingRevisionService::class);
        $revisions->shouldNotReceive('fetchFeed');
        $this->app->instance(BookingRevisionService::class, $revisions);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Missing Channex property ID for booking feed pull.');

        (new HandleOtaBookingService())->processFeed([]);
    }

    public function test_cancellation_without_an_external_booking_id_is_rejected_before_any_transaction(): void
    {
        DB::shouldReceive('transaction')->never();

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Missing external booking ID for cancellation.');

        (new HandleOtaBookingService())->cancel([]);
    }

    public function test_missing_guest_email_uses_a_stable_non_deliverable_address(): void
    {
        $service = new TestableHandleOtaBookingService();

        $first = $service->guest(['customer' => []], 'booking-123');
        $second = $service->guest(['customer' => []], 'booking-123');

        $this->assertSame($first['email'], $second['email']);
        $this->assertStringEndsWith('@invalid.local', $first['email']);
        $this->assertSame('OTA Guest', $first['name']);
        $this->assertFalse($first['can_email']);
    }

    public function test_acknowledgement_happens_only_after_the_upsert_transaction_returns(): void
    {
        $transactionReturned = false;

        DB::shouldReceive('transaction')
            ->once()
            ->andReturnUsing(function () use (&$transactionReturned) {
                $transactionReturned = true;

                return [
                    'property_id' => 42,
                    'send_email' => false,
                    'guest' => null,
                    'reservation' => null,
                    'external_id' => 'booking-1',
                ];
            });

        $service = new AcknowledgementOrderHandleOtaBookingService();
        $service->onAcknowledge = function () use (&$transactionReturned): void {
            $this->assertTrue($transactionReturned);
        };

        $service->handle([
            'status' => 'new',
            'booking_revision_id' => 'revision-1',
        ]);

        $this->assertSame(['revision-1'], $service->acknowledged);
    }

    public function test_modification_restores_old_dates_before_acknowledgement(): void
    {
        DB::beginTransaction();

        try {
            $uuid = (string) Str::uuid();
            $property = new Property();
            $property->forceFill([
                'name' => 'Test Property - OTA Modification ' . $uuid,
                'type' => 'multiple',
                'slug' => 'test-ota-modification-' . $uuid,
                'token' => $uuid,
                'allow' => false,
                'channex_property_id' => $uuid,
                'channex_group_id' => (string) Str::uuid(),
                'channex_synced' => true,
            ])->save();

            $apartment = new Apartment();
            $apartment->forceFill([
                'property_id' => $property->id,
                'name' => 'Test Room ' . $uuid,
                'slug' => 'test-room-' . $uuid,
                'type' => 'multiple',
                'price' => 100,
                'quantity' => 1,
                'allow' => true,
                'uuid' => $uuid,
                'channex_room_type_id' => (string) Str::uuid(),
                'channex_synced' => true,
            ])->save();

            $guest = GuestUser::create([
                'name' => 'OTA',
                'last_name' => 'Guest',
                'email' => 'ota-' . $uuid . '@example.com',
                'phone_number' => '08000000000',
                'image' => '',
            ]);

            $header = UserReservation::withoutEvents(function () use ($property, $guest, $uuid) {
                $header = new UserReservation();
                $header->forceFill([
                    'property_id' => $property->id,
                    'guest_user_id' => $guest->id,
                    'external_id' => 'booking-' . $uuid,
                    'status' => 'confirmed',
                    'is_cancelled' => false,
                    'payment_type' => 'ota',
                    'coming_from' => 'ota',
                ])->save();

                return $header;
            });

            $oldLine = Reservation::withoutEvents(function () use ($header, $property, $apartment) {
                return Reservation::create([
                    'user_reservation_id' => $header->id,
                    'property_id' => $property->id,
                    'apartment_id' => $apartment->id,
                    'quantity' => 1,
                    'price' => 200,
                    'rate' => 1,
                    'checkin' => '2026-09-01',
                    'checkout' => '2026-09-03',
                    'length_of_stay' => 2,
                ]);
            });

            $events = [];
            $inventory = Mockery::mock(InventorySyncService::class);
            $inventory->shouldReceive('queueUserReservation')->zeroOrMoreTimes();
            $inventory->shouldReceive('queueReservation')
                ->twice()
                ->andReturnUsing(function (Reservation $reservation) use (&$events): void {
                    $events[] = ($reservation->trashed() ? 'deleted:' : 'created:')
                        . $reservation->checkin->toDateString();
                });
            $this->app->instance(InventorySyncService::class, $inventory);

            $service = new AcknowledgementOrderHandleOtaBookingService();
            $service->onAcknowledge = function () use (&$events): void {
                $events[] = 'ack';
            };

            $service->handle([
                'property_id' => $property->channex_property_id,
                'booking_id' => $header->external_id,
                'booking_revision_id' => (string) Str::uuid(),
                'inserted_at' => '2026-08-20T12:00:00Z',
                'status' => 'confirmed',
                'currency' => 'NGN',
                'amount' => 200,
                'customer' => [
                    'name' => 'OTA',
                    'surname' => 'Guest',
                    'mail' => $guest->email,
                    'phone' => $guest->phone_number,
                ],
                'rooms' => [[
                    'room_type_id' => $apartment->channex_room_type_id,
                    'checkin_date' => '2026-09-10',
                    'checkout_date' => '2026-09-12',
                    'days' => [100, 100],
                ]],
            ]);

            $this->assertSame([
                'deleted:2026-09-01',
                'created:2026-09-10',
                'ack',
            ], $events);
            $this->assertSoftDeleted('reservations', ['id' => $oldLine->id]);
            $this->assertDatabaseHas('reservations', [
                'user_reservation_id' => $header->id,
                'apartment_id' => $apartment->id,
                'checkin' => '2026-09-10 00:00:00',
                'deleted_at' => null,
            ]);
        } finally {
            DB::rollBack();
        }
    }

    public function test_active_revision_reinstates_a_cancelled_booking(): void
    {
        $reservation = new UserReservation();
        $reservation->status = 'cancelled';
        $reservation->is_cancelled = true;

        (new TestableHandleOtaBookingService())
            ->markReservationActiveForTest($reservation, ['status' => 'modified']);

        $this->assertSame('modified', $reservation->status);
        $this->assertFalse((bool) $reservation->is_cancelled);
    }

    public function test_absent_cancellation_is_audited_as_an_idempotent_success(): void
    {
        $logs = Mockery::mock(CertificationLogService::class);
        $logs->shouldReceive('log')
            ->once()
            ->with(
                'booking_webhook',
                'success',
                'booking_cancellation_absent',
                42,
                null,
                [],
                Mockery::on(function ($payload) {
                    return $payload['booking_revision_id'] === 'revision-1'
                        && $payload['booking_id'] === 'booking-1'
                        && $payload['property_id'] === 'property-1'
                        && $payload['status'] === 'cancelled';
                }),
                ['local_state' => 'already_absent'],
                'Cancellation recorded for absent local OTA booking booking-1'
            )
            ->andReturn(new ChannexCertificationLog());
        $this->app->instance(CertificationLogService::class, $logs);

        $property = (new \ReflectionClass(Property::class))->newInstanceWithoutConstructor();
        $property->setRawAttributes(['id' => 42], true);

        (new TestableHandleOtaBookingService())->recordAbsentCancellationForTest([
            'booking_revision_id' => 'revision-1',
            'booking_id' => 'booking-1',
            'property_id' => 'property-1',
            'status' => 'cancelled',
        ], 'booking-1', $property);
    }
}

class RecordingFeedHandleOtaBookingService extends HandleOtaBookingService
{
    public array $processed = [];
    public array $acknowledged = [];

    public function handle(array $payload): void
    {
        $this->processed[] = [
            'action' => 'upsert',
            'revision_id' => $payload['booking_revision_id'],
            'booking_id' => $payload['booking_id'],
        ];
        $this->acknowledgeRevision($payload);
    }

    public function cancel(array $payload): void
    {
        $this->processed[] = [
            'action' => 'cancel',
            'revision_id' => $payload['booking_revision_id'],
            'booking_id' => $payload['booking_id'],
        ];
        $this->acknowledgeRevision($payload);
    }

    protected function acknowledgeRevision(array $payload, ?int $propertyId = null): void
    {
        $this->acknowledged[] = $payload['booking_revision_id'];
    }
}

class TestableHandleOtaBookingService extends HandleOtaBookingService
{
    public function guest(array $payload, string $externalId): array
    {
        return $this->guestDetails($payload, $externalId);
    }

    public function recordAbsentCancellationForTest(
        array $payload,
        string $externalId,
        Property $property
    ): void {
        $this->recordAbsentCancellation($payload, $externalId, $property);
    }

    public function markReservationActiveForTest(UserReservation $reservation, array $payload): void
    {
        $this->markReservationActive($reservation, $payload);
    }
}

class AcknowledgementOrderHandleOtaBookingService extends HandleOtaBookingService
{
    /** @var callable */
    public $onAcknowledge;

    public array $acknowledged = [];

    protected function acknowledgeRevision(array $payload, ?int $propertyId = null): void
    {
        ($this->onAcknowledge)();
        $this->acknowledged[] = $payload['booking_revision_id'];
    }
}
