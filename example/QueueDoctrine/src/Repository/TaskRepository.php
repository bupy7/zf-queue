<?php

namespace QueueDoctrine\Repository;

use ExDoctrine\Repository\RepositoryAbstract;
use Bupy7\Queue\Repository\TaskRepositoryInterface;
use Bupy7\Queue\Entity\TaskInterface;

class TaskRepository extends RepositoryAbstract implements TaskRepositoryInterface
{
    public function findForRun(int $limit = null): array
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select(['t'])
            ->from('QueueDoctrine\Entity\Task', 't')
            ->where('t.statusId IN (:statusId)')
            ->setParameter('statusId', [
                TaskInterface::STATUS_WAIT,
                TaskInterface::STATUS_ERROR,
            ]);
        if ($limit !== null) {
            $qb->setMaxResults($limit);
        }
        return $qb->getQuery()->getResult();
    }
}
