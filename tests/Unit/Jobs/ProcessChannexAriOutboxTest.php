<?php

namespace Tests\Unit\Jobs;

use App\Jobs\ProcessChannexAriOutbox;
use Illuminate\Contracts\Queue\ShouldBeUniqueUntilProcessing;
use PHPUnit\Framework\TestCase;

class ProcessChannexAriOutboxTest extends TestCase
{
    public function test_the_processor_lock_expires_and_is_released_before_processing(): void
    {
        $job = new ProcessChannexAriOutbox();

        $this->assertInstanceOf(ShouldBeUniqueUntilProcessing::class, $job);
        $this->assertSame(300, $job->uniqueFor);
        $this->assertSame('process-channex-ari-outbox', $job->uniqueId());
    }
}
