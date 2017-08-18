<?php

namespace Bupy7\Queue\Repository;

interface TaskRepositoryInterface
{
    /**
     * Returns entities has status Task::STATUS_RUN or Task::STATUS_ERROR for run.
     * @return \Bupy7\Queue\Entity\Task[]
     */
    public function findForRun(int $limit = null): array;
}
