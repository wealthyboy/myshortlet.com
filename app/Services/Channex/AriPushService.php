<?php

namespace App\Services\Channex;

use App\Exceptions\ChannexRateLimitException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;

class AriPushService extends ChannexClient
{
    public function pushAvailability(array $values): array
    {
        $this->acquireAriSlots($values, 'availability');

        return $this->post('/availability', [
            'values' => $values,
        ]);
    }

    public function pushRestrictions(array $values): array
    {
        $this->acquireAriSlots($values, 'restrictions');

        return $this->post('/restrictions', [
            'values' => $values,
        ]);
    }

    protected function acquireAriSlots(array $values, string $endpoint): void
    {
        $credentialKey = sha1((string) config('services.channex.key'));
        $globalKey = 'channex:ari:' . $credentialKey;
        $globalLimit = (int) config('services.channex.ari_limit_per_minute', 20);
        $propertyLimit = (int) config('services.channex.ari_endpoint_limit_per_property', 10);
        $propertyIds = collect($values)->pluck('property_id')->filter()->unique()->values();

        $keys = $propertyIds->map(function ($propertyId) use ($credentialKey, $endpoint, $propertyLimit) {
            return [
                'key' => "channex:ari:{$credentialKey}:{$propertyId}:{$endpoint}",
                'limit' => $propertyLimit,
            ];
        })->prepend([
            'key' => $globalKey,
            'limit' => $globalLimit,
        ]);

        $claimLock = Cache::lock('channex:ari:limiter-claim:' . $credentialKey, 10);
        if (! $claimLock->get()) {
            throw new ChannexRateLimitException(1);
        }

        try {
            foreach ($keys as $limiter) {
                if (RateLimiter::tooManyAttempts($limiter['key'], $limiter['limit'])) {
                    throw new ChannexRateLimitException(RateLimiter::availableIn($limiter['key']));
                }
            }

            foreach ($keys as $limiter) {
                RateLimiter::hit($limiter['key'], 60);
            }
        } finally {
            $claimLock->release();
        }
    }
}
