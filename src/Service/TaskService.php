<?php

namespace Bupy7\Queue\Service;

use Bupy7\Queue\Entity\TaskInterface;
use DateTime;
use Bupy7\Queue\Manager\EntityManagerInterface;
use Bupy7\Queue\Exception\InvalidValueException;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerAwareTrait;

class TaskService implements EventManagerAwareInterface
{
    public const EVENT_BEFORE_SAVE = 'beforeSave';

    use EventManagerAwareTrait;

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function add(string $name, array $params): void
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

        $this->getEventManager()->trigger(self::EVENT_BEFORE_SAVE, $this, ['task' => $task]);

        $this->entityManager->persist($task);
        $this->entityManager->flush();
    }
}
