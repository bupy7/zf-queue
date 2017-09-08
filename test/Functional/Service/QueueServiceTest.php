<?php

namespace Bupy7\Queue\Test\Functional\Service;

use PHPUnit\Framework\TestCase;
use Bupy7\Queue\Test\Functional\AppTrait;
use Bupy7\Queue\Entity\TaskInterface;
use DateTime;
use Bupy7\Queue\Service\QueueService;
use Zend\EventManager\EventInterface;
use Exception;
use Bupy7\Queue\Test\Assert\Entity\Task;

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

    public function testAddSuccess()
    {
        $sm = $this->getSm($this->memoryConfig);

        $sm->get('MemoryQueueService')->add('Bupy7\Queue\Test\Assert\Command\SomeCommand', [
            'email' => 'some@email.com',
        ]);

        /** @var \Bupy7\Queue\Test\Assert\Manager\DummyEntityManager $saved */
        $em = $sm->get('DummyEntityManager');

        /** @var TaskInterface $result */
        $result = end($em->saved);
        $this->assertEquals($result->getParams()->toArray(), ['email' => 'some@email.com']);
        $this->assertEquals(TaskInterface::STATUS_WAIT, $result->getStatusId());
        $this->assertEquals(0, $result->getNumberErrors());
        $this->assertInstanceOf(DateTime::class, $result->getCreatedAt());
        $this->assertEquals('Bupy7\Queue\Test\Assert\Command\SomeCommand', $result->getName());
    }

    public function testBeforeAddEvent()
    {
        $sm = $this->getSm($this->memoryConfig);

        $eventTask = null;
        $sm->get('MemoryQueueService')->getEventManager()
            ->attach(QueueService::EVENT_BEFORE_ADD, function (EventInterface $event) use (&$eventTask) {
                $eventTask = $event->getParam('task');
            });
        $sm->get('MemoryQueueService')->add('Bupy7\Queue\Test\Assert\Command\SomeCommand', [
            'email' => 'some@email.com',
        ]);

        $this->assertInstanceOf(TaskInterface::class, $eventTask);
    }

    public function testErrorExecuteEvent()
    {
        $sm = $this->getSm($this->memoryExceptionConfig);

        $sm->get('MemoryTaskRepository')->entities = [
            (new Task)->setId(1)->setName('Bupy7\Queue\Test\Assert\Task\ExceptionHelloTask'),
        ];

        $eventException = null;
        $sm->get('MemoryQueueService')->getEventManager()
            ->attach(QueueService::EVENT_ERROR_EXECUTE, function (EventInterface $event) use (&$eventException) {
                $eventException = $event->getParam('exception');
            });
        try {
            $sm->get('MemoryQueueService')->run();
        } finally {
            $this->assertInstanceOf(Exception::class, $eventException);
        }
    }
}
