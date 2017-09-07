<?php

namespace Bupy7\Queue\Service;

use Bupy7\Queue\Entity\TaskInterface;
use DateTime;
use Bupy7\Queue\Manager\EntityManagerInterface;
use Bupy7\Queue\Exception\InvalidValueException;

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

    public function add(string $name, array $params): bool
    {
        $task = $this->entityManager->newInstance(TaskInterface::class);
        if (!$task instanceof TaskInterface) {
            throw new InvalidValueException(sprintf(
                'The class "%s" is invalid. Expected instance of "%s"',
                get_class($task),
                TaskInterface::class
            ));
        }

        $task->getParams()->fromArray($params);
        $task->setName($name)
            ->setStatusId(TaskInterface::STATUS_WAIT)
            ->setCreatedAt(new DateTime)
            ->setNumberErrors(0);

        $this->entityManager->persist($task);
        $this->entityManager->flush();

        return true;
    }
}
