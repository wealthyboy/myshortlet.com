<?php

namespace App\Services\Channex;

use App\Models\Apartment;
use Illuminate\Support\Facades\Log;

class PricingService extends ChannexClient
{
    public function sync(Apartment $apartment): void
    {
        $reponse =  $this->post('/restrictions', [
            'values' => [
                [
                    'property_id'  => $apartment->property->channex_property_id,
                    'rate_plan_id' => $apartment->channex_rate_plan_id,
                    'date_from' => now()->toDateString(),
                    'date_to' => now()->addDays(365)->toDateString(),
                    'rate' => $apartment->price * 100
                ],
            ],
        ]);

        Log::info($reponse);
    }
}
