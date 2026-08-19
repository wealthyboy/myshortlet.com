<?php

namespace Tests\Feature;

use App\Jobs\ProcessChannexBookingWebhook;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;

class ChannexWebhookTest extends TestCase
{
    public function test_it_fails_closed_when_the_webhook_secret_is_missing(): void
    {
        Bus::fake();
        config()->offsetUnset('services.channex.webhook_secret');
        config([
            'services.channex.webhook_secret_header' => 'X-Channex-Webhook-Secret',
        ]);

        $this->postJson('/webhook/channex', [
            'event' => 'booking_new',
            'payload' => ['booking_revision_id' => 'revision-1'],
        ], [
            'X-Channex-Webhook-Secret' => 'attacker-controlled-secret',
        ])->assertStatus(503);

        Bus::assertNothingDispatched();
    }

    public function test_it_fails_closed_when_the_webhook_secret_is_blank(): void
    {
        Bus::fake();
        config([
            'services.channex.webhook_secret' => '   ',
            'services.channex.webhook_secret_header' => 'X-Channex-Webhook-Secret',
        ]);

        $this->postJson('/webhook/channex', [
            'event' => 'booking_new',
            'payload' => ['booking_revision_id' => 'revision-1'],
        ], [
            'X-Channex-Webhook-Secret' => 'attacker-controlled-secret',
        ])->assertStatus(503);

        Bus::assertNothingDispatched();
    }

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

    public function test_it_preserves_the_top_level_property_id_for_the_queued_worker(): void
    {
        Bus::fake();
        config([
            'services.channex.webhook_secret' => 'correct-secret',
            'services.channex.webhook_secret_header' => 'X-Channex-Webhook-Secret',
        ]);

        $this->postJson('/webhook/channex', [
            'event' => 'booking_new',
            'property_id' => 'property-uuid-1',
        ], [
            'X-Channex-Webhook-Secret' => 'correct-secret',
        ])->assertOk()->assertJson(['status' => 'accepted']);

        Bus::assertDispatched(ProcessChannexBookingWebhook::class, function ($job) {
            $payload = new \ReflectionProperty($job, 'payload');
            $payload->setAccessible(true);

            return $payload->getValue($job)['property_id'] === 'property-uuid-1';
        });
    }

    public function test_connection_test_returns_ok_without_dispatching_a_job(): void
    {
        Bus::fake();
        config([
            'services.channex.webhook_secret' => 'correct-secret',
            'services.channex.webhook_secret_header' => 'X-Channex-Webhook-Secret',
        ]);

        $this->postJson('/webhook/channex', [
            'event' => 'connection_test',
        ], [
            'X-Channex-Webhook-Secret' => 'correct-secret',
        ])->assertOk()->assertExactJson(['status' => 'ok']);

        Bus::assertNothingDispatched();
    }

    public function test_empty_authenticated_test_payload_returns_ok_without_dispatching_a_job(): void
    {
        Bus::fake();
        config([
            'services.channex.webhook_secret' => 'correct-secret',
            'services.channex.webhook_secret_header' => 'X-Channex-Webhook-Secret',
        ]);

        $this->postJson('/webhook/channex', [], [
            'X-Channex-Webhook-Secret' => 'correct-secret',
        ])->assertOk()->assertExactJson(['status' => 'ok']);

        Bus::assertNothingDispatched();
    }

    public function test_generic_authenticated_test_event_returns_ok_without_dispatching_a_job(): void
    {
        Bus::fake();
        config([
            'services.channex.webhook_secret' => 'correct-secret',
            'services.channex.webhook_secret_header' => 'X-Channex-Webhook-Secret',
        ]);

        $this->postJson('/webhook/channex', ['event' => 'test'], [
            'X-Channex-Webhook-Secret' => 'correct-secret',
        ])->assertOk()->assertExactJson(['status' => 'ok']);

        Bus::assertNothingDispatched();
    }
}
