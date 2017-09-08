<?php

namespace Bupy7\Queue\Test\Assert\Repository;

use Bupy7\Queue\Repository\TaskRepositoryInterface;
use Bupy7\Queue\Test\Assert\Entity\Task;

class MemoryExceptionTaskRepository implements TaskRepositoryInterface
{
    /**
     * @var array
     */
    public $entities = [];

    public function __construct()
    {
        $this->entities = [
            (new Task)->setId(1)->setName('Bupy7\Queue\Test\Assert\Task\NotExistsTask'),
        ];
    }

    public function findForRun(int $limit = null): array
    {
        return $this->entities;
    }
}
