<?php

namespace Bupy7\Queue\Test\Assert\Manager;

use Bupy7\Queue\Manager\EntityManagerInterface;

class DummyEntityManager implements EntityManagerInterface
{
    public function persist($entity): void
    {
        // dummy
    }

    public function flush(): void
    {
        // dummy
    }
}
