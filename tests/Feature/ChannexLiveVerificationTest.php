<?php

namespace Tests\Feature;

use Tests\TestCase;

class ChannexLiveVerificationTest extends TestCase
{
    public function test_it_fails_closed_before_database_access_when_the_verification_token_is_missing(): void
    {
        config([
            'services.channex.verification_token' => '',
            // If the controller reaches its Property query, this test fails
            // instead of accidentally relying on a developer database.
            'database.default' => 'intentionally-unconfigured',
        ]);

        $this->getJson('/channex/live-verification?token=attacker-controlled-token')
            ->assertStatus(403)
            ->assertExactJson(['message' => 'Unauthorized']);
    }

    public function test_it_rejects_a_request_that_omits_the_configured_verification_token(): void
    {
        config([
            'services.channex.verification_token' => 'correct-token',
            'database.default' => 'intentionally-unconfigured',
        ]);

        $this->getJson('/channex/live-verification')
            ->assertStatus(403)
            ->assertExactJson(['message' => 'Unauthorized']);
    }

    public function test_reservation_verifier_fails_closed_before_database_access(): void
    {
        config([
            'services.channex.verification_token' => '',
            'database.default' => 'intentionally-unconfigured',
        ]);

        $this->postJson('/api/channex/verify-reservation', [
            'property' => '1',
            'apartment' => '1',
            'checkin' => '2027-09-10',
            'checkout' => '2027-09-11',
            'execute' => true,
        ], [
            'Authorization' => 'Bearer attacker-controlled-token',
        ])->assertStatus(403)->assertExactJson(['message' => 'Unauthorized']);
    }

    public function test_reservation_options_require_a_bearer_token(): void
    {
        config([
            'services.channex.verification_token' => 'correct-token',
            'database.default' => 'intentionally-unconfigured',
        ]);

        $this->getJson('/api/channex/verify-reservation')
            ->assertStatus(403)
            ->assertExactJson(['message' => 'Unauthorized']);
    }

    public function test_certification_setup_fails_closed_before_database_access(): void
    {
        config([
            'services.channex.verification_token' => '',
            'database.default' => 'intentionally-unconfigured',
        ]);

        $this->postJson('/api/channex/setup-certification', [
            'execute' => true,
        ], [
            'Authorization' => 'Bearer attacker-controlled-token',
        ])->assertStatus(403)->assertExactJson(['message' => 'Unauthorized']);
    }
}
