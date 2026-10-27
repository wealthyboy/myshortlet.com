<?php

namespace App\Services\ChannexPro;

use App\Models\ApartmentChannelPriceRule;
use App\Models\Property;
use App\Jobs\NotifyChannexProReservationEvent;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ChannelPricing
{
    public function channels(): array
    {
        $webhook = (string) config('services.channexpro.webhook_url');
        $token = (string) config('services.channexpro.shared_token');
        $url = preg_replace('#/v1/source/webhook/?$#', '/v1/channels', $webhook);
        if (! $token || $url === $webhook || strtolower((string) parse_url($url, PHP_URL_SCHEME)) !== 'https') return [];
        return Cache::remember('channexpro-price-channels-'.hash('sha256', $url.'|'.$token), 300, function () use ($url, $token) {
            $response = Http::acceptJson()->withToken($token)->withoutRedirecting()->timeout(10)->get($url);
            if (! $response->successful() || ! is_array($response->json('channels'))) throw new \RuntimeException('Channel catalogue unavailable.');
            return collect($response->json('channels'))->filter(fn ($row) => is_array($row) && is_string($row['code'] ?? null)
                && preg_match('/^[A-Za-z0-9][A-Za-z0-9_.-]{0,95}$/', $row['code']) && is_string($row['title'] ?? null))->values()->all();
        });
    }

    public function export(Property $property): array
    {
        return ApartmentChannelPriceRule::whereIn('apartment_id', $property->apartments()->pluck('id'))->orderBy('id')->get()
            ->map(fn ($rule) => ['room_type_id' => (string) $rule->apartment_id, 'channel' => $rule->channel,
                'currency' => $rule->currency, 'percent' => $rule->percent, 'amount' => $rule->amount])->all();
    }

    public function validatePrice(float $base, float $percent, float $amount): void
    {
        $price = round($base * (1 + $percent / 100) + $amount, 2);
        if (! is_finite($price) || $price < 0.01 || $price > 100000000) throw ValidationException::withMessages([
            'pricing' => 'This adjustment would produce an invalid nightly price. Reduce the markdown or check the base rate.',
        ]);
    }

    public function notify(Property $property): void
    {
        $from = now()->startOfDay();
        NotifyChannexProReservationEvent::dispatch([
            'schema' => 'channexpro.source-event.v1', 'event' => 'ari.updated', 'event_id' => (string) Str::uuid(),
            'property_id' => (string) $property->id, 'occurred_at' => now()->toIso8601String(),
            'affected' => [['property_id' => (string) $property->id, 'from' => $from->toDateString(), 'to' => $from->copy()->addDays(499)->toDateString()]],
        ])->onConnection('database')->afterCommit();
    }
}
