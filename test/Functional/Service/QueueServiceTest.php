<?php

namespace Bupy7\Queue\Test\Functional\Service;

use PHPUnit\Framework\TestCase;
use Bupy7\Queue\Test\Functional\AppTrait;
use Bupy7\Queue\Entity\TaskInterface;

/**
 * @author Belosludcev Vasily <https://github.com/bupy7>
 */
class QueueServiceTest extends TestCase
{
    use AppTrait;

    public function testRun()
    {
        $sm = $this->getSm();

        $queueService = $sm->get('MemoryQueueService');
        $queueService->run();

        $tasks = $sm->get('MemoryTaskRepository')->findByStatusId(TaskInterface::STATUS_ERROR);
        $this->assertEquals(1, count($tasks));

        $tasks = $sm->get('MemoryTaskRepository')->findByStatusId(TaskInterface::STATUS_OK);
        $this->assertEquals(1, count($tasks));

        $tasks = $sm->get('MemoryTaskRepository')->findByStatusId(TaskInterface::STATUS_IMPOSSIBLE);
        $this->assertEquals(1, count($tasks));
    }
}
