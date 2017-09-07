<?php

namespace Bupy7\Queue\Test\Assert\Repository;

use Bupy7\Queue\Repository\TaskRepositoryInterface;
use Bupy7\Queue\Test\Assert\Entity\Task;

class MemoryExceptionTaskRepository implements TaskRepositoryInterface
{
    /**
     * @var array
     */
    private $entities = [];

    public function __construct()
    {
        $this->entities = [
            (new Task('Bupy7\Queue\Test\Assert\Task\NotExistsTask'))->setId(1),
        ];
    }

    public function findForRun(int $limit = null): array
    {
        return $this->entities;
    }
}
