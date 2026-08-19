<?php

namespace Tests\Unit\Jobs;

use App\Jobs\ProcessChannexAriOutbox;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldBeUniqueUntilProcessing;
use PHPUnit\Framework\TestCase;

class ProcessChannexAriOutboxTest extends TestCase
{
    public function test_the_processor_lock_is_held_until_processing_finishes(): void
    {
        $job = new ProcessChannexAriOutbox();

        $this->assertInstanceOf(ShouldBeUnique::class, $job);
        $this->assertNotInstanceOf(ShouldBeUniqueUntilProcessing::class, $job);
        $this->assertSame(300, $job->uniqueFor);
        $this->assertSame('process-channex-ari-outbox', $job->uniqueId());
    }
}
