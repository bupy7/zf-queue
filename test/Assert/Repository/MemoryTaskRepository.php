<?php

namespace Bupy7\Queue\Test\Assert\Repository;

use Bupy7\Queue\Repository\TaskRepositoryInterface;
use Bupy7\Queue\Test\Assert\Entity\Task;

class MemoryTaskRepository implements TaskRepositoryInterface
{
    /**
     * @var array
     */
    private $entities = [];

    public function __construct()
    {
        $this->entities = [
            (new Task('Bupy7\Queue\Test\Assert\Task\ErrorHelloTask'))->setId(1),
            (new Task('Bupy7\Queue\Test\Assert\Task\SuccessHelloTask'))->setId(2),
            (new Task('Bupy7\Queue\Test\Assert\Task\ErrorHelloTask'))->setId(3)
                ->setNumberErrors(4)
                ->setStatusId(Task::STATUS_ERROR),
        ];
    }

    public function findForRun(int $limit = null): array
    {
        return $this->entities;
    }

    public function findByStatusId(int $statusId): array
    {
        $result = [];
        foreach ($this->entities as $entity) {
            if ($entity->getStatusId() == $statusId) {
                $result[] = $entity;
            }
        }
        return $result;
    }

    public function find(int $id): ?Task
    {
        foreach ($this->entities as $entity) {
            if ($entity->getId() == $id) {
                return $entity;
            }
        }
        return null;
    }
}
