<?php

namespace Bupy7\Queue\Test\Assert\Repository;

use Bupy7\Queue\Repository\TaskRepositoryInterface;
use Bupy7\Queue\Entity\Task;

class MemoryTaskRepository implements TaskRepositoryInterface
{
    /**
     * @var array
     */
    private $entities = [];

    public function __construct()
    {
        $this->entities = [
            (new Task)->setId(1)->setName('Bupy7\Queue\Test\Assert\Task\ErrorHelloTask'),
            (new Task)->setId(2)->setName('Bupy7\Queue\Test\Assert\Task\SuccessHelloTask'),
            (new Task)->setId(3)
                ->incNumberErrors(4)
                ->setStatusId(Task::STATUS_ERROR)
                ->setName('Bupy7\Queue\Test\Assert\Task\ErrorHelloTask'),
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
}
