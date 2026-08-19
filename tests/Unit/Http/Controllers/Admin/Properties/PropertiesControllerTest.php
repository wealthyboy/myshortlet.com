<?php

namespace Tests\Unit\Http\Controllers\Admin\Properties;

use App\Http\Controllers\Admin\Properties\PropertiesController;
use App\Jobs\SyncPropertyToChannex;
use App\Models\Property;
use Illuminate\Support\Facades\Bus;
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
}