<?php

namespace Bupy7\Queue\Service;

use Bupy7\Queue\Repository\TaskRepositoryInterface;
use Bupy7\Queue\Entity\TaskInterface as TaskEntityInterface;
use Bupy7\Queue\Manager\EntityManagerInterface;
use Bupy7\Queue\Manager\QueueManager;
use DateTime;
use Bupy7\Queue\Exception\UnknownTaskException;
use Bupy7\Queue\Task\TaskInterface;
use Bupy7\Queue\Options\ModuleOptions;
use Throwable;
use Laminas\EventManager\EventManagerAwareInterface;
use Laminas\EventManager\EventManagerAwareTrait;
use Bupy7\Queue\Exception\InvalidValueException;

class QueueService implements EventManagerAwareInterface
{
    public const EVENT_ERROR_EXECUTE = 'errorExecute';
    /**
     * @since 1.0.1
     */
    public const EVENT_EXECUTED = 'executed';
    public const EVENT_BEFORE_ADD = 'beforeAdd';

    use EventManagerAwareTrait;

    /**
     * @var TaskRepositoryInterface
     */
    protected $taskRepository;
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;
    /**
     * @var QueueManager
     */
    protected $queueManager;
    /**
     * @var ModuleOptions
     */
    protected $config;

    public function __construct(
        TaskRepositoryInterface $taskRepository,
        EntityManagerInterface $entityManager,
        QueueManager $queueManager,
        ModuleOptions $config
    ) {
        $this->taskRepository = $taskRepository;
        $this->entityManager = $entityManager;
        $this->queueManager = $queueManager;
        $this->config = $config;
    }

    public function run(): void
    {
        $entities = $this->taskRepository->findForRun($this->config->getOneTimeLimit() ?: null);
        foreach ($entities as $entity) {
            if (in_array($entity->getStatusId(), [
                TaskEntityInterface::STATUS_WAIT,
                TaskEntityInterface::STATUS_ERROR,
            ])) {
                $this->executeTask($entity);
            }
        }
    }

    public function add(string $name, array $params): void
    {
        $task = $this->entityManager->newInstance(TaskEntityInterface::class);
        if (!$task instanceof TaskEntityInterface) {
            throw new InvalidValueException(sprintf(
                'The class "%s" is invalid. Expected instance of "%s"',
                get_class($task),
                TaskEntityInterface::class
            ));
        }

        $task->getParams()->fromArray($params);
        $task->setName($name)
            ->setStatusId(TaskEntityInterface::STATUS_WAIT)
            ->setCreatedAt(new DateTime)
            ->setNumberErrors(0);

        $this->getEventManager()->trigger(self::EVENT_BEFORE_ADD, $this, ['task' => $task]);

        $this->entityManager->persist($task);
        $this->entityManager->flush();
    }

    protected function executeTask(TaskEntityInterface $entity): void
    {
        if (!$this->queueManager->has($entity->getName())) {
            throw new UnknownTaskException(sprintf('"%s task is unknown."', $entity->getName()));
        }

        $entity->setRunAt(new DateTime);
        $entity->setStatusId(TaskEntityInterface::STATUS_IN_PROCESSING);
        $this->entityManager->flush($entity);

        /** @var TaskInterface $task */
        $task = $this->queueManager->get($entity->getName());

        try {
            if ($task->execute(clone $entity->getParams())) {
                $entity->setStatusId(TaskEntityInterface::STATUS_OK);
            } else {
                $entity->setStatusId(TaskEntityInterface::STATUS_ERROR);
            }
        } catch (Throwable $e) {
            $entity->setStatusId(TaskEntityInterface::STATUS_ERROR);

            // event trigger
            $this->getEventManager()->trigger(self::EVENT_ERROR_EXECUTE, $this, [
                'exception' => $e,
            ]);
        } finally {
            if ($entity->getStatusId() === TaskEntityInterface::STATUS_ERROR) {
                $entity->incNumberErrors();
                if (
                    $this->config->getErrorLimit() !== 0
                    && $entity->getNumberErrors() >= $this->config->getErrorLimit()
                ) {
                    $entity->setStatusId(TaskEntityInterface::STATUS_IMPOSSIBLE);
                }
            }
            $entity->setStopAt(new DateTime);
            $this->entityManager->flush($entity);
        }

        if ($entity->getStatusId() === TaskEntityInterface::STATUS_OK) {
            $this->getEventManager()->trigger(self::EVENT_EXECUTED, $this, [
                'name' => $entity->getName(),
                'params' => clone $entity->getParams(),
            ]);
        }
    }
}
