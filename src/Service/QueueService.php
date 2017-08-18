<?php

namespace Bupy7\Queue\Service;

use Bupy7\Queue\Repository\TaskRepositoryInterface;
use Bupy7\Queue\Entity\Task as TaskEntity;
use Bupy7\Queue\Manager\EntityManagerInterface;
use Bupy7\Queue\Manager\QueueManager;
use DateTime;
use Bupy7\Queue\Exception\UnknownTaskException;
use Bupy7\Queue\Task\TaskInterface;
use Bupy7\Queue\Options\ModuleOptions;

class QueueService
{
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
                TaskEntity::STATUS_WAIT,
                TaskEntity::STATUS_ERROR,
            ])) {
                $this->executeTask($entity);
            }
        }
        $this->entityManager->flush();
    }

    protected function executeTask(TaskEntity $entity): void
    {
        if (!$this->queueManager->has($entity->getName())) {
            throw new UnknownTaskException(sprintf('"%s task is unknown."', $entity->getName()));
        }
        /** @var TaskInterface $task */
        $task = $this->queueManager->get($entity->getName());
        $entity->setRunAt(new DateTime);
        if ($task->execute()) {
            $entity->setStatusId(TaskEntity::STATUS_OK);
        } else {
            $entity->incNumberErrors();
            if ($entity->getNumberErrors() >= $this->config->getErrorLimit()) {
                $entity->setStatusId(TaskEntity::STATUS_IMPOSSIBLE);
            } else {
                $entity->setStatusId(TaskEntity::STATUS_ERROR);
            }
        }
        $entity->setStopAt(new DateTime);
        $this->entityManager->persist($entity);
    }
}
