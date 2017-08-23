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

    /**
     * @var array
     */
    private $memoryConfig = [
        'service_manager' => [
            'aliases' => [
                'MemoryTaskRepository' => 'Bupy7\Queue\Test\Assert\Repository\MemoryTaskRepository',
            ],
        ],
    ];
    /**
     * @var array
     */
    private $memoryExceptionConfig = [
        'service_manager' => [
            'aliases' => [
                'MemoryTaskRepository' => 'Bupy7\Queue\Test\Assert\Repository\MemoryExceptionTaskRepository',
            ],
        ],
    ];

    public function testRunError()
    {
        $sm = $this->getSm($this->memoryConfig);

        $sm->get('MemoryQueueService')->run();

        $tasks = $sm->get('MemoryTaskRepository')->findByStatusId(TaskInterface::STATUS_ERROR);
        $this->assertEquals(1, count($tasks));
    }

    public function testRunOk()
    {
        $sm = $this->getSm($this->memoryConfig);

        $sm->get('MemoryQueueService')->run();

        $tasks = $sm->get('MemoryTaskRepository')->findByStatusId(TaskInterface::STATUS_OK);
        $this->assertEquals(1, count($tasks));
    }

    public function testRunImpossible()
    {
        $sm = $this->getSm($this->memoryConfig);

        $sm->get('MemoryQueueService')->run();

        $tasks = $sm->get('MemoryTaskRepository')->findByStatusId(TaskInterface::STATUS_IMPOSSIBLE);
        $this->assertEquals(1, count($tasks));
    }

    /**
     * @expectedException \Bupy7\Queue\Exception\UnknownTaskException
     */
    public function testRunWithException()
    {
        $sm = $this->getSm($this->memoryExceptionConfig);

        $sm->get('MemoryQueueService')->run();
    }
}
