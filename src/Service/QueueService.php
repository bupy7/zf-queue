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
use Exception;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerAwareTrait;

class QueueService implements EventManagerAwareInterface
{
    public const EVENT_ERROR_EXECUTE = 'errorExecute';

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
            if ($task->execute($entity->getParams())) {
                $entity->setStatusId(TaskEntityInterface::STATUS_OK);
            } else {
                $entity->setStatusId(TaskEntityInterface::STATUS_ERROR);
            }
        } catch (Exception $e) {
            $entity->setStatusId(TaskEntityInterface::STATUS_ERROR);
            // event trigger
            $this->getEventManager()->trigger(self::EVENT_ERROR_EXECUTE, $this, [
                'exception' => $e,
            ]);
        } finally {
            if ($entity->getStatusId() === TaskEntityInterface::STATUS_ERROR) {
                $entity->incNumberErrors();
            }
            if (
                $this->config->getErrorLimit() !== 0
                && $entity->getNumberErrors() >= $this->config->getErrorLimit()
            ) {
                $entity->setStatusId(TaskEntityInterface::STATUS_IMPOSSIBLE);
            }
            $entity->setStopAt(new DateTime);
        }

        $this->entityManager->flush($entity);
    }
}
