<?php

namespace Tests\Unit\Http\Controllers\Admin\Properties;

use App\Http\Controllers\Admin\Properties\PropertiesController;
use App\Jobs\SyncPropertyToChannex;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PropertiesControllerTest extends TestCase
{
    public function test_new_property_is_queued_for_channex_sync(): void
    {
        Bus::fake();

        $property = new Property();
        $property->id = 123;

        (new TestablePropertiesController())->queueProperty($property);

        Bus::assertDispatched(SyncPropertyToChannex::class, function ($job) {
            $propertyId = new \ReflectionProperty($job, 'propertyId');
            $propertyId->setAccessible(true);

            return $propertyId->getValue($job) === 123;
        });
    }

    public function test_multiple_apartments_are_saved_for_the_property(): void
    {
        DB::beginTransaction();

        try {
            $property = new Property();
            $property->name = 'Apartment creation test';
            $property->address = '1 Test Street';
            $property->description = 'Temporary test property';
            $property->type = 'multiple';
            $property->mode = 'shortlet';
            $property->slug = 'apartment-creation-test';
            $property->token = 123456;
            $property->save();

            $request = new Request([
                'type' => 'multiple',
                'room_name' => [11 => 'Twin Room', 12 => 'Double Room'],
                'room_price' => [11 => 100, 12 => 150],
                'room_max_adults' => [11 => 2, 12 => 2],
                'room_quantity' => [11 => 1, 12 => 1],
                'price_mode' => [11 => 'per night', 12 => 'per night'],
                'room_number' => [11 => 1, 12 => 1],
                'room_toilets' => [11 => 1, 12 => 1],
                'apartment_allow' => [11 => 1, 12 => 1],
            ]);

            (new TestablePropertiesController())->saveMultipleApartments($request, $property);

            $this->assertSame(
                ['Double Room', 'Twin Room'],
                $property->apartments()->orderBy('name')->pluck('name')->all()
            );
        } finally {
            DB::rollBack();
        }
    }
}

class TestablePropertiesController extends PropertiesController
{
    public function __construct()
    {
    }

    public function queueProperty(Property $property): void
    {
        $this->queueChannexSync($property);
    }

    public function saveMultipleApartments(Request $request, Property $property): void
    {
        $this->propertyWithMultipleApartments($request, $property);
    }
}