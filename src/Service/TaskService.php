<?php

namespace Bupy7\Queue\Service;

use Bupy7\Queue\Entity\TaskInterface;
use DateTime;
use Bupy7\Queue\Manager\EntityManagerInterface;

class TaskService
{
    private const DEFAULT_NUMBER_ERRORS = 0;

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function create(array $data, TaskInterface $task): bool
    {
        if (!isset($data['name'])) {
            return false;
        }
        $task->setStatusId(TaskInterface::STATUS_WAIT)
            ->setCreatedAt(new DateTime)
            ->setNumberErrors(self::DEFAULT_NUMBER_ERRORS)
            ->setName($data['name']);
        $this->entityManager->persist($task);
        $this->entityManager->flush();
    }
}
