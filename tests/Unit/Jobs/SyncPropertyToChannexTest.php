<?php

namespace Tests\Unit\Jobs;

use App\Jobs\SyncApartmentToChannex;
use App\Jobs\SyncPropertyToChannex;
use App\Models\Apartment;
use App\Models\Property;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;

class SyncPropertyToChannexTest extends TestCase
{
    public function test_apartments_are_queued_after_the_property_sync(): void
    {
        Bus::fake();

        $firstApartment = new Apartment();
        $firstApartment->id = 41;
        $secondApartment = new Apartment();
        $secondApartment->id = 42;

        $property = new Property();
        $property->setRelation('apartments', collect([
            $firstApartment,
            $secondApartment,
        ]));

        (new TestableSyncPropertyToChannex(10))->queueApartments($property);

        Bus::assertDispatchedTimes(SyncApartmentToChannex::class, 2);
        foreach ([41, 42] as $expectedId) {
            Bus::assertDispatched(SyncApartmentToChannex::class, function ($job) use ($expectedId) {
                $apartmentId = new \ReflectionProperty($job, 'apartmentId');
                $apartmentId->setAccessible(true);

                return $apartmentId->getValue($job) === $expectedId;
            });
        }
    }
}

class TestableSyncPropertyToChannex extends SyncPropertyToChannex
{
    public function queueApartments(Property $property): void
    {
        $this->queueApartmentSyncs($property);
    }
}