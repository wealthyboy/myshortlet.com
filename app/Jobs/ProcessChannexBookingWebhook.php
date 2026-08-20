<?php

namespace App\Jobs;

use App\Services\Channex\HandleOtaBookingService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUniqueUntilProcessing;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\Middleware\WithoutOverlapping;

class ProcessChannexBookingWebhook implements ShouldQueue, ShouldBeUniqueUntilProcessing
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // Overlap middleware releases also count as attempts. Allow enough attempts
    // for a follow-up property trigger to wait behind the full 180-second lock,
    // while still limiting genuine processing exceptions to five.
    public int $tries = 25;
    public int $maxExceptions = 5;
    public int $timeout = 120;
    public int $uniqueFor = 1800;

    protected string $action;
    protected array $payload;

    public function __construct(string $action, array $payload)
    {
        $this->action = $action;
        $this->payload = $payload;
    }

    public function backoff(): array
    {
        return [60, 180, 300, 600];
    }

    public function uniqueId(): string
    {
        $propertyId = data_get($this->payload, 'property_id')
            ?? data_get($this->payload, 'property.id');

        return 'channex-booking-feed-' . ($propertyId ?: sha1(json_encode($this->payload)));
    }

    /**
     * Channex can deliver more than one notification for the same property while
     * an unacknowledged revision is still visible in the feed. Serialize those
     * jobs so only one worker can pull, persist and acknowledge that revision.
     */
    public function middleware(): array
    {
        $propertyId = data_get($this->payload, 'property_id')
            ?? data_get($this->payload, 'property.id');
        $revisionId = data_get($this->payload, 'booking_revision_id')
            ?? data_get($this->payload, 'revision_id')
            ?? data_get($this->payload, 'booking.revision_id')
            ?? data_get($this->payload, 'booking_revision.id');

        $lockKey = $propertyId
            ? 'property-' . $propertyId
            : 'revision-' . ($revisionId ?: sha1(json_encode($this->payload)));

        return [
            (new WithoutOverlapping('channex-booking-' . $lockKey))
                ->releaseAfter(10)
                ->expireAfter(180),
        ];
    }

    public function handle(HandleOtaBookingService $service): void
    {
        $service->processFeed($this->payload);
    }
}
