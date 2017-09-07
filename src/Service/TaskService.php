<?php

namespace Bupy7\Queue\Service;

use Bupy7\Queue\Entity\TaskInterface;
use DateTime;
use Bupy7\Queue\Manager\EntityManagerInterface;

class TaskService
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function add(TaskInterface $task): bool
    {
        if (empty($task->getName())) {
            throw new InvalidArgumentException(sprintf('%s::$name is required', get_class($task)));
        }

        $task->setStatusId(TaskInterface::STATUS_WAIT)
            ->setCreatedAt(new DateTime)
            ->setNumberErrors(0);

        $this->entityManager->persist($task);
        $this->entityManager->flush();

        return true;
    }
}
