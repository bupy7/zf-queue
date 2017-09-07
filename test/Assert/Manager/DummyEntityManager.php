<?php

namespace Bupy7\Queue\Test\Assert\Manager;

use Bupy7\Queue\Manager\EntityManagerInterface;
use Bupy7\Queue\Test\Assert\Entity\Task;

class DummyEntityManager implements EntityManagerInterface
{
    /**
     * @var Task[]
     */
    public $persist = [];
    /**
     * @var Task[]
     */
    public $saved = [];

    public function newInstance(string $name)
    {
        if ($name !== 'Bupy7\Queue\Entity\TaskInterface') {
            return null;
        }
        return new Task;
    }

    public function persist($entity): void
    {
        $this->persist[] = $entity;
    }

    public function flush(): void
    {
        foreach ($this->persist as $entity) {
            $this->saved[spl_object_hash($entity)] = $entity;
        }
        $this->persist = [];
    }
}
