<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class NotifyChannexProReservationEvent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 10;
    public int $timeout = 30;

    public function __construct(public array $payload)
    {
    }

    public function backoff(): array
    {
        return [15, 30, 60, 120, 300, 600];
    }

    public function handle(): void
    {
        if (! (bool) config('services.channexpro.events_enabled', true)) {
            return;
        }

        $token = trim((string) config('services.channexpro.shared_token'));
        $url = trim((string) config('services.channexpro.webhook_url'));

        if ($token === '') {
            throw new RuntimeException('CHANNEXPRO_SHARED_TOKEN is not configured.');
        }

        if ($url === '') {
            throw new RuntimeException('ChannexPro source webhook URL is not configured.');
        }

        $event = (string) ($this->payload['event'] ?? 'reservation.updated');

        $response = Http::acceptJson()
            ->asJson()
            ->withToken($token)
            ->withHeaders([
                'X-ChannexPro-Event' => $event,
                'X-ChannexPro-Source' => 'avm',
            ])
            ->timeout(15)
            ->retry(2, 750, fn ($exception) => $exception instanceof ConnectionException)
            ->post($url, $this->payload);

        if ($response->failed()) {
            $message = data_get($response->json(), 'message')
                ?: data_get($response->json(), 'error')
                ?: 'HTTP '.$response->status();

            throw new RuntimeException('ChannexPro reservation event failed: '.$message);
        }

        Log::info('Reservation event delivered to ChannexPro.', [
            'event' => $event,
            'event_id' => $this->payload['event_id'] ?? null,
            'reservation_id' => data_get($this->payload, 'reservation.id'),
            'channexpro_event_id' => data_get($response->json(), 'event_id'),
        ]);
    }
}
