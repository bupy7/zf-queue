<?php

namespace Bupy7\Queue\Test\Functional\Service;

use PHPUnit\Framework\TestCase;
use Bupy7\Queue\Test\Functional\AppTrait;
use Bupy7\Queue\Test\Assert\Entity\Task;
use DateTime;

/**
 * @author Belosludcev Vasily <https://github.com/bupy7>
 */
class TaskServiceTest extends TestCase
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

    public function testAddSuccess()
    {
        $sm = $this->getSm($this->memoryConfig);

        $sm->get('MemoryTaskService')->add('Bupy7\Queue\Test\Assert\Command\SomeCommand', [
            'email' => 'some@email.com',
        ]);

        /** @var \Bupy7\Queue\Test\Assert\Manager\DummyEntityManager $saved */
        $em = $sm->get('DummyEntityManager');

        /** @var Task $result */
        $result = end($em->saved);
        $this->assertEquals($result->getParams()->toArray(), ['email' => 'some@email.com']);
        $this->assertEquals(Task::STATUS_WAIT, $result->getStatusId());
        $this->assertEquals(0, $result->getNumberErrors());
        $this->assertInstanceOf(DateTime::class, $result->getCreatedAt());
        $this->assertEquals('Bupy7\Queue\Test\Assert\Command\SomeCommand', $result->getName());
    }
}
