<?php

namespace Tests\Feature;

use App\Jobs\ProcessChannexBookingWebhook;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;

class ChannexWebhookTest extends TestCase
{
    public function test_it_rejects_an_invalid_webhook_secret(): void
    {
        config([
            'services.channex.webhook_secret' => 'correct-secret',
            'services.channex.webhook_secret_header' => 'X-Channex-Webhook-Secret',
        ]);

        $this->postJson('/webhook/channex', [
            'event' => 'booking_new',
            'payload' => ['booking_revision_id' => 'revision-1'],
        ], [
            'X-Channex-Webhook-Secret' => 'wrong-secret',
        ])->assertStatus(401);
    }

    public function test_it_queues_booking_processing_and_returns_immediately(): void
    {
        Bus::fake();
        config([
            'services.channex.webhook_secret' => 'correct-secret',
            'services.channex.webhook_secret_header' => 'X-Channex-Webhook-Secret',
        ]);

        $this->postJson('/webhook/channex', [
            'event' => 'booking_new',
            'payload' => ['booking_revision_id' => 'revision-1'],
        ], [
            'X-Channex-Webhook-Secret' => 'correct-secret',
        ])->assertOk()->assertJson(['status' => 'accepted']);

        Bus::assertDispatched(ProcessChannexBookingWebhook::class);
    }
}
