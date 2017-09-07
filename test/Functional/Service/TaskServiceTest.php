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

        $result = $sm->get('MemoryTaskService')->add('Bupy7\Queue\Test\Assert\Command\SomeCommand', [
            'email' => 'some@email.com',
        ]);

        $this->assertTrue($result);
    }
}
