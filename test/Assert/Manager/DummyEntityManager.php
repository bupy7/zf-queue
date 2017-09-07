<?php

namespace Bupy7\Queue\Test\Assert\Manager;

use Bupy7\Queue\Manager\EntityManagerInterface;
use Bupy7\Queue\Exception\UnknownEntityException;
use Bupy7\Queue\Test\Assert\Entity\Task;

class DummyEntityManager implements EntityManagerInterface
{
    public function newInstance(string $name)
    {
        if ($name !== 'Bupy7\Queue\Entity\TaskInterface') {
            throw new UnknownEntityException;
        }
        return new Task;
    }

    public function persist($entity): void
    {
        // dummy
    }

    public function flush(): void
    {
        // dummy
    }
}
