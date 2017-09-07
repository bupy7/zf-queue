<?php

namespace Bupy7\Queue\Test\Functional\Entity;

use PHPUnit\Framework\TestCase;
use Bupy7\Queue\Test\Assert\Entity\Task;

/**
 * @author Belosludcev Vasily <https://github.com/bupy7>
 */
class TaskTest extends TestCase
{
    public function testCreateSuccess()
    {
        $task = new Task('Some\Class\Name');

        $this->assertEquals('Some\Class\Name', $task->getName());
    }
}
