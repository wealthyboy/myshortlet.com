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
}
