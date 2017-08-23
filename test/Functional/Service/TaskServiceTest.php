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

    public function testCreateSuccess()
    {
        $sm = $this->getSm($this->memoryConfig);

        $task = new Task;
        $result = $sm->get('MemoryTaskService')->create([
            'name' => 'Bupy7\Queue\Test\Assert\Command\SomeCommand',
            'params' => ['email' => 'some@email.com']
        ], $task);

        $this->assertTrue($result);
        $this->assertEquals('Bupy7\Queue\Test\Assert\Command\SomeCommand', $task->getName());
        $this->assertEquals('some@email.com', $task->getParams()->get('email'));
    }

    public function testCreateError()
    {
        $sm = $this->getSm($this->memoryConfig);

        $task = new Task;
        $result = $sm->get('MemoryTaskService')->create(['params' => ['email' => 'some@email.com']], $task);

        $this->assertFalse($result);
    }
}
