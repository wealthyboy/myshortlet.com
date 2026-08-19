<?php

namespace Tests\Unit\Services\Channex;

use App\Services\Channex\AriPushService;
use App\Services\Channex\FullSyncService;
use Mockery;
use Tests\TestCase;

class FullSyncServiceTest extends TestCase
{
    public function test_it_rejects_an_accepted_ari_response_without_a_task_id(): void
    {
        $service = new TestableFullSyncService(Mockery::mock(AriPushService::class));

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Channex availability update was accepted without a task ID.');

        $service->assertTaskIds(['data' => [['attributes' => ['status' => 'pending']]]], 'availability');
    }

    public function test_it_accepts_an_ari_response_with_a_task_id(): void
    {
        $service = new TestableFullSyncService(Mockery::mock(AriPushService::class));

        $service->assertTaskIds(['data' => [['id' => 'task-uuid-1']]], 'restrictions');

        $this->addToAssertionCount(1);
    }
}

class TestableFullSyncService extends FullSyncService
{
    public function assertTaskIds(array $response, string $endpoint): void
    {
        $this->assertTaskIdsReturned($response, $endpoint);
    }
}
