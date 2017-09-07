<?php

namespace Bupy7\Queue\Test\Functional\Service;

use PHPUnit\Framework\TestCase;
use Bupy7\Queue\Test\Functional\AppTrait;
use Bupy7\Queue\Test\Assert\Entity\Task;

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

        $task = new Task('Bupy7\Queue\Test\Assert\Command\SomeCommand');
        $task->getParams()->fromArray(['email' => 'some@email.com']);
        $result = $sm->get('MemoryTaskService')->add($task);

        $this->assertTrue($result);
        $this->assertEquals('Bupy7\Queue\Test\Assert\Command\SomeCommand', $task->getName());
        $this->assertEquals('some@email.com', $task->getParams()->get('email'));
    }

    /**
     * @expectedException \Bupy7\Queue\Exception\InvalidArgumentException
     */
    public function testAddError()
    {
        $sm = $this->getSm($this->memoryConfig);

        $task = new Task('');
        $task->getParams()->fromArray(['email' => 'some@email.com']);
        $result = $sm->get('MemoryTaskService')->add($task);
    }
}
