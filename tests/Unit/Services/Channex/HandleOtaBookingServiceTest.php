<?php

namespace Tests\Unit\Services\Channex;

use App\Services\Channex\BookingRevisionService;
use App\Services\Channex\HandleOtaBookingService;
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
}

class TestableHandleOtaBookingService extends HandleOtaBookingService
{
    public function recover(array $payload): array
    {
        $payload = $this->resolvePayloadFromFeedFallback($payload);

        return $this->resolvePayloadFromRevision($payload);
    }
}
