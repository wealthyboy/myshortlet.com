<?php

namespace Tests\Feature;

use Tests\TestCase;

class VerifyChannexReservationCommandTest extends TestCase
{
    public function test_it_refuses_to_create_a_reservation_without_execute(): void
    {
        $this->artisan('channex:verify-reservation', [
            'property' => '1',
            'apartment' => '1',
            'checkin' => '2027-09-10',
            'checkout' => '2027-09-11',
        ])
            ->expectsOutput('No reservation was created. Add --execute after reviewing the selected property, room, and dates.')
            ->assertExitCode(1);
    }

    public function test_move_week_requires_immediate_processing_before_creation(): void
    {
        $this->artisan('channex:verify-reservation', [
            'property' => '1',
            'apartment' => '1',
            'checkin' => '2027-09-10',
            'checkout' => '2027-09-11',
            '--execute' => true,
            '--move-week' => true,
        ])
            ->expectsOutput('--move-week requires --process. No reservation was created.')
            ->assertExitCode(1);
    }
}