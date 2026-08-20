<?php

namespace Tests\Unit\Jobs;

use App\Jobs\ProcessChannexBookingWebhook;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldBeUniqueUntilProcessing;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use PHPUnit\Framework\TestCase;

class ProcessChannexBookingWebhookTest extends TestCase
{
    public function test_booking_notifications_for_the_same_property_are_serialized(): void
    {
        $first = new ProcessChannexBookingWebhook('upsert', [
            'property_id' => 'property-1',
        ]);
        $second = new ProcessChannexBookingWebhook('upsert', [
            'property_id' => 'property-1',
        ]);

        $firstMiddleware = $first->middleware()[0];
        $secondMiddleware = $second->middleware()[0];

        $this->assertInstanceOf(WithoutOverlapping::class, $firstMiddleware);
        $this->assertSame('channex-booking-property-property-1', $firstMiddleware->key);
        $this->assertSame($firstMiddleware->key, $secondMiddleware->key);
        $this->assertSame(10, $firstMiddleware->releaseAfter);
        $this->assertSame(180, $firstMiddleware->expiresAfter);
        $this->assertInstanceOf(ShouldBeUnique::class, $first);
        $this->assertInstanceOf(ShouldBeUniqueUntilProcessing::class, $first);
        $this->assertSame('channex-booking-feed-property-1', $first->uniqueId());
        $this->assertSame($first->uniqueId(), $second->uniqueId());
        $this->assertSame(1800, $first->uniqueFor);
        $this->assertSame(25, $first->tries);
        $this->assertSame(5, $first->maxExceptions);
    }
}
