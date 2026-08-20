<?php

namespace Tests\Unit\Services\Channex;

use App\Services\Channex\BookingRevisionService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class BookingRevisionServiceTest extends TestCase
{
    public function test_empty_200_response_is_a_successful_acknowledgement(): void
    {
        config([
            'services.channex.base_url' => 'https://staging.channex.test/api/v1',
            'services.channex.key' => 'test-key',
        ]);
        Http::fake([
            'https://staging.channex.test/api/v1/booking_revisions/revision-1/ack' =>
                Http::response('', 200),
        ]);

        $result = (new BookingRevisionService())->acknowledge('revision-1');

        $this->assertSame([
            'acknowledged' => true,
            'http_status' => 200,
        ], $result);
        Http::assertSentCount(1);
    }

    public function test_failed_http_response_is_not_treated_as_an_acknowledgement(): void
    {
        config([
            'services.channex.base_url' => 'https://staging.channex.test/api/v1',
            'services.channex.key' => 'test-key',
        ]);
        Http::fake([
            'https://staging.channex.test/api/v1/booking_revisions/revision-1/ack' =>
                Http::response(['errors' => ['code' => 'temporary_failure']], 503),
        ]);

        $this->assertNull((new BookingRevisionService())->acknowledge('revision-1'));
        Http::assertSentCount(1);
    }

    public function test_feed_requests_one_large_oldest_first_page_for_the_property(): void
    {
        config([
            'services.channex.base_url' => 'https://staging.channex.test/api/v1',
            'services.channex.key' => 'test-key',
        ]);
        Http::fake([
            'https://staging.channex.test/api/v1/booking_revisions/feed*' =>
                Http::response(['data' => [], 'meta' => ['total' => 0, 'limit' => 100]], 200),
        ]);

        $result = (new BookingRevisionService())->fetchFeed('property-1');

        $this->assertSame([], $result['data']);
        Http::assertSent(function ($request) {
            parse_str((string) parse_url($request->url(), PHP_URL_QUERY), $query);

            return data_get($query, 'order.inserted_at') === 'asc'
                && data_get($query, 'filter.property_id') === 'property-1'
                && (int) data_get($query, 'pagination.limit') === 100;
        });
        Http::assertSentCount(1);
    }
}
