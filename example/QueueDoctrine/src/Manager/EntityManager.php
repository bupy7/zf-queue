<?php

namespace QueueDoctrine\Manager;

use Bupy7\Queue\Manager\EntityManagerInterface;
use Doctrine\ORM\EntityManager as ORMEntityManager;
use QueueDoctrine\Entity\Task;

class EntityManager implements EntityManagerInterface
{
    /**
     * @var ORMEntityManager
     */
    protected $entityManager;

    public function __construct(ORMEntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function persist($entity): void
    {
        $this->entityManager->persist($entity);
    }

    public function flush(): void
    {
        $this->entityManager->flush();
    }

    public function newInstance(string $name)
    {
        if ($name !== 'Bupy7\Queue\Entity\TaskInterface') {
            return null;
        }
        return new Task;
    }
}
