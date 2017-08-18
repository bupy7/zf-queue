<?php

namespace Bupy7\Queue\Test\Service;

use PHPUnit\Framework\TestCase;
use Bupy7\Queue\Test\AppTrait;
use Bupy7\Queue\Entity\Task;

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

        $tasks = $sm->get('MemoryTaskRepository')->findByStatusId(Task::STATUS_ERROR);
        $this->assertEquals(1, count($tasks));

        $tasks = $sm->get('MemoryTaskRepository')->findByStatusId(Task::STATUS_OK);
        $this->assertEquals(1, count($tasks));

        $tasks = $sm->get('MemoryTaskRepository')->findByStatusId(Task::STATUS_IMPOSSIBLE);
        $this->assertEquals(1, count($tasks));
    }
}
