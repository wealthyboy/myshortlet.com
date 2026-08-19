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

    public function test_task_id_extractor_accepts_a_single_task_object(): void
    {
        $job = new TestableProcessChannexAriOutbox();

        $this->assertSame(
            ['task-uuid-1'],
            $job->taskIds(['data' => ['type' => 'task', 'id' => 'task-uuid-1']])
        );
    }
}

class TestableProcessChannexAriOutbox extends ProcessChannexAriOutbox
{
    public function taskIds(array $response): array
    {
        return $this->extractTaskIds($response);
    }
}
