<?php

namespace Tests\Feature;

use App\Models\Property;
use App\Services\Channex\GroupPropertyService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ChannexDeletedPropertyRecoveryTest extends TestCase
{
    public function test_it_recreates_property_and_group_after_remote_404s(): void
    {
        DB::beginTransaction();

        try {
            config([
                'services.channex.base_url' => 'https://channex.test/api/v1',
                'services.channex.key' => 'test-key',
            ]);

            $property = new Property();
            $property->name = 'Deleted mapping test';
            $property->address = '1 Test Street';
            $property->description = 'Temporary recovery test';
            $property->type = 'multiple';
            $property->mode = 'shortlet';
            $property->slug = 'deleted-mapping-test';
            $property->token = 456789;
            $property->channex_property_id = '11111111-1111-4111-8111-111111111111';
            $property->channex_group_id = '22222222-2222-4222-8222-222222222222';
            $property->channex_synced = true;
            $property->save();

            Http::fake([
                '*/properties/11111111-1111-4111-8111-111111111111' => Http::response([], 404),
                '*/groups/22222222-2222-4222-8222-222222222222' => Http::response([], 404),
                '*/groups' => Http::response(['data' => ['id' => '33333333-3333-4333-8333-333333333333']], 200),
                '*/properties' => Http::response(['data' => ['id' => '44444444-4444-4444-8444-444444444444']], 200),
            ]);

            app(GroupPropertyService::class)->sync($property);
            $property->refresh();

            $this->assertSame('33333333-3333-4333-8333-333333333333', $property->channex_group_id);
            $this->assertSame('44444444-4444-4444-8444-444444444444', $property->channex_property_id);
            $this->assertTrue((bool) $property->channex_synced);
        } finally {
            DB::rollBack();
        }
    }
}