<?php

namespace Tests\Unit\Jobs;

use App\Jobs\ProcessChannexBookingWebhook;
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
    }
}
