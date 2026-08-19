<?php

namespace Tests\Feature;

use App\Models\Property;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class SetupChannexCertificationCommandTest extends TestCase
{
    public function test_it_creates_only_the_isolated_certification_structure(): void
    {
        DB::beginTransaction();

        try {
            config([
                'cache.default' => 'redis',
                'queue.default' => 'database',
                'services.channex.base_url' => 'https://channex.test/api/v1',
                'services.channex.key' => 'test-key',
                'services.channex.webhook_secret' => 'test-secret',
                'services.channex.verification_token' => 'test-token',
                'services.channex.webhook_secret_header' => 'X-Channex-Webhook-Secret',
                'services.channex.ari_limit_per_minute' => 20,
                'services.channex.ari_endpoint_limit_per_property' => 10,
            ]);

            $ids = [
                'groups' => '11111111-1111-4111-8111-111111111111',
                'properties' => '22222222-2222-4222-8222-222222222222',
                'room_types' => [
                    '33333333-3333-4333-8333-333333333333',
                    '44444444-4444-4444-8444-444444444444',
                ],
                'rate_plans' => [
                    '55555555-5555-4555-8555-555555555555',
                    '66666666-6666-4666-8666-666666666666',
                    '77777777-7777-4777-8777-777777777777',
                    '88888888-8888-4888-8888-888888888888',
                ],
            ];
            $roomIndex = 0;
            $planIndex = 0;

            Http::fake(function (Request $request) use ($ids, &$roomIndex, &$planIndex) {
                $path = parse_url($request->url(), PHP_URL_PATH);

                if ($request->method() === 'POST' && str_ends_with($path, '/groups')) {
                    return Http::response(['data' => ['id' => $ids['groups']]], 200);
                }
                if ($request->method() === 'POST' && str_ends_with($path, '/properties')) {
                    return Http::response(['data' => ['id' => $ids['properties']]], 200);
                }
                if ($request->method() === 'POST' && str_ends_with($path, '/room_types')) {
                    return Http::response(['data' => ['id' => $ids['room_types'][$roomIndex++]]], 200);
                }
                if ($request->method() === 'POST' && str_ends_with($path, '/rate_plans')) {
                    return Http::response(['data' => ['id' => $ids['rate_plans'][$planIndex++]]], 200);
                }

                return Http::response(['data' => ['id' => basename($path)]], 200);
            });

            $exitCode = Artisan::call('channex:setup-certification', ['--execute' => true]);
            $this->assertSame(0, $exitCode, Artisan::output());

            $property = Property::with('apartments.channexRatePlans')
                ->where('name', 'Test Property - Channex Final Certification')
                ->firstOrFail();

            $this->assertFalse((bool) $property->allow);
            $this->assertSame($ids['properties'], $property->channex_property_id);
            $this->assertSame(['Double Room', 'Twin Room'], $property->apartments->sortBy('name')->pluck('name')->values()->all());
            $this->assertTrue($property->apartments->every(fn ($room) => $room->allow && $room->channex_synced));
            $this->assertTrue($property->apartments->every(function ($room) {
                return $room->channexRatePlans->sortBy('name')->pluck('name')->values()->all() === [
                    'Bed & Breakfast Rate',
                    'Best Available Rate',
                ];
            }));
            $this->assertSame(1, Property::where('name', 'Test Property - Channex Final Certification')->count());
        } finally {
            DB::rollBack();
        }
    }
}