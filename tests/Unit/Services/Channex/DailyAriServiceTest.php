<?php

namespace Tests\Unit\Services\Channex;

use App\Models\Apartment;
use App\Services\Channex\DailyAriService;
use PHPUnit\Framework\TestCase;

class DailyAriServiceTest extends TestCase
{
    public function test_it_stores_room_availability_separately_from_rate_plan_state(): void
    {
        // Apartment's legacy constructor loads SystemSetting from the database.
        // This service test only needs a typed model identifier, so bypass that
        // unrelated constructor dependency and set the Eloquent attributes.
        $apartment = (new \ReflectionClass(Apartment::class))->newInstanceWithoutConstructor();
        $apartment->setRawAttributes(['id' => 12], true);

        $service = new RecordingDailyAriService();
        $service->storeRange($apartment, '2026-08-20', '2026-08-20', [
            'rate_plan_id' => 91,
            'availability' => 3,
            'rate' => 70000,
            'min_stay_arrival' => 2,
            'stop_sell' => false,
        ]);

        $this->assertSame([
            [
                'apartment_id' => 12,
                'date' => '2026-08-20',
                'rate_plan_id' => null,
                'updates' => ['availability' => 3],
            ],
            [
                'apartment_id' => 12,
                'date' => '2026-08-20',
                'rate_plan_id' => 91,
                'updates' => [
                    'price' => 70000,
                    'min_stay_arrival' => 2,
                    'stop_sell' => false,
                ],
            ],
        ], $service->writes);
    }
}

class RecordingDailyAriService extends DailyAriService
{
    public array $writes = [];

    protected function persistDailyRow(
        Apartment $apartment,
        string $date,
        ?int $ratePlanId,
        array $updates
    ): void {
        $this->writes[] = [
            'apartment_id' => $apartment->id,
            'date' => $date,
            'rate_plan_id' => $ratePlanId,
            'updates' => $updates,
        ];
    }
}
