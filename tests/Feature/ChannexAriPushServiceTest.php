<?php

namespace Tests\Feature;

use App\Exceptions\ChannexRateLimitException;
use App\Services\Channex\AriPushService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class ChannexAriPushServiceTest extends TestCase
{
    protected string $limiterKey;

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'services.channex.base_url' => 'https://staging.channex.test/api/v1',
            'services.channex.key' => 'test-key',
            'services.channex.ari_limit_per_minute' => 20,
        ]);

        $this->limiterKey = 'channex:ari:' . sha1('test-key');
        RateLimiter::clear($this->limiterKey);
    }

    public function test_it_posts_a_batched_availability_request(): void
    {
        Http::fake([
            '*' => Http::response([
                'data' => [['id' => 'task-1', 'type' => 'task']],
            ]),
        ]);

        app(AriPushService::class)->pushAvailability([
            [
                'property_id' => 'property-1',
                'room_type_id' => 'room-1',
                'date_from' => '2026-11-21',
                'date_to' => '2026-11-21',
                'availability' => 7,
            ],
            [
                'property_id' => 'property-1',
                'room_type_id' => 'room-2',
                'date_from' => '2026-11-25',
                'date_to' => '2026-11-25',
                'availability' => 0,
            ],
        ]);

        Http::assertSentCount(1);
        Http::assertSent(function ($request) {
            return $request->url() === 'https://staging.channex.test/api/v1/availability'
                && $request->hasHeader('user-api-key', 'test-key')
                && count($request['values']) === 2;
        });
    }

    public function test_it_stops_before_exceeding_the_configured_ari_limit(): void
    {
        config(['services.channex.ari_limit_per_minute' => 1]);
        Http::fake(['*' => Http::response(['data' => []])]);

        $service = app(AriPushService::class);
        $service->pushRestrictions([['rate_plan_id' => 'rate-1']]);

        $this->expectException(ChannexRateLimitException::class);
        $service->pushRestrictions([['rate_plan_id' => 'rate-2']]);
    }
}
