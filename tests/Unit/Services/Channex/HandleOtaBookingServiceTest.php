<?php

namespace Tests\Unit\Services\Channex;

use App\Services\Channex\BookingRevisionService;
use App\Services\Channex\HandleOtaBookingService;
use Illuminate\Support\Facades\DB;
use Mockery;
use Tests\TestCase;

class HandleOtaBookingServiceTest extends TestCase
{
    public function test_feed_revision_is_not_fetched_again_by_id(): void
    {
        $revisions = Mockery::mock(BookingRevisionService::class);
        $revisions->shouldReceive('fetchFeed')
            ->once()
            ->with('property-1')
            ->andReturn([
                'data' => [[
                    'id' => 'revision-1',
                    'attributes' => [
                        'booking_id' => 'booking-1',
                        'property_id' => 'property-1',
                        'status' => 'new',
                    ],
                ]],
            ]);
        $revisions->shouldNotReceive('fetch');
        $this->app->instance(BookingRevisionService::class, $revisions);

        $payload = (new TestableHandleOtaBookingService())->recover([
            'property_id' => 'property-1',
        ]);

        $this->assertSame('revision-1', $payload['booking_revision_id']);
        $this->assertSame('booking-1', $payload['booking_id']);
        $this->assertSame('feed', $payload['_channex_revision_source']);
    }

    public function test_revision_id_is_fetched_once_when_no_feed_lookup_is_possible(): void
    {
        $revisions = Mockery::mock(BookingRevisionService::class);
        $revisions->shouldNotReceive('fetchFeed');
        $revisions->shouldReceive('fetch')
            ->once()
            ->with('revision-2')
            ->andReturn([
                'data' => [
                    'attributes' => [
                        'booking_id' => 'booking-2',
                        'status' => 'new',
                    ],
                ],
            ]);
        $this->app->instance(BookingRevisionService::class, $revisions);

        $payload = (new TestableHandleOtaBookingService())->recover([
            'booking_revision_id' => 'revision-2',
        ]);

        $this->assertSame('booking-2', $payload['booking_id']);
        $this->assertSame('id', $payload['_channex_revision_source']);
    }

    public function test_empty_feed_marks_a_repeated_notification_as_a_no_op(): void
    {
        $revisions = Mockery::mock(BookingRevisionService::class);
        $revisions->shouldReceive('fetchFeed')
            ->once()
            ->with('property-1')
            ->andReturn(['data' => []]);
        $revisions->shouldNotReceive('fetch');
        $this->app->instance(BookingRevisionService::class, $revisions);

        $payload = (new TestableHandleOtaBookingService())->recover([
            'property_id' => 'property-1',
        ]);

        $this->assertTrue($payload['_channex_no_pending_revision']);
    }

    public function test_cancellation_without_an_external_booking_id_is_rejected_before_any_reservation_query(): void
    {
        DB::shouldReceive('transaction')->never();

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Missing external booking ID for cancellation.');

        (new HandleOtaBookingService())->cancel([]);
    }

    public function test_upsert_trigger_routes_a_cancelled_feed_revision_to_cancellation(): void
    {
        $service = new UpsertRoutingHandleOtaBookingService();

        $service->handle(['status' => 'cancelled']);

        $this->assertSame([['status' => 'cancelled']], $service->cancellations);
    }

    public function test_cancel_trigger_routes_an_older_confirmed_feed_revision_to_upsert(): void
    {
        $service = new CancellationRoutingHandleOtaBookingService();

        $service->cancel(['status' => 'confirmed']);

        $this->assertSame([['status' => 'confirmed']], $service->upserts);
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
}

class TestableHandleOtaBookingService extends HandleOtaBookingService
{
    public function recover(array $payload): array
    {
        $payload = $this->resolvePayloadFromFeedFallback($payload);

        return $this->resolvePayloadFromRevision($payload);
    }

    public function guest(array $payload, string $externalId): array
    {
        return $this->guestDetails($payload, $externalId);
    }
}

class UpsertRoutingHandleOtaBookingService extends HandleOtaBookingService
{
    public array $cancellations = [];

    public function cancel(array $payload): void
    {
        $this->cancellations[] = $payload;
    }
}

class CancellationRoutingHandleOtaBookingService extends HandleOtaBookingService
{
    public array $upserts = [];

    public function handle(array $payload): void
    {
        $this->upserts[] = $payload;
    }
}
