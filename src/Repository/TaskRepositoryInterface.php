<?php

namespace Bupy7\Queue\Repository;

interface TaskRepositoryInterface
{
    /**
     * Returns entities has status TaskAbstract::STATUS_RUN or TaskAbstract::STATUS_ERROR for run.
     * @return \Bupy7\Queue\Entity\TaskAbstract[]
     */
    public function findForRun(int $limit): array;
}
