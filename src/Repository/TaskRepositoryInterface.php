<?php

namespace Bupy7\Queue\Repository;

interface TaskRepositoryInterface
{
    /**
     * Returns entities has status \Bupy7\Queue\Entity\TaskInterface::STATUS_RUN or
     * \Bupy7\Queue\Entity\TaskInterface::STATUS_ERROR for run.
     * @return \Bupy7\Queue\Entity\TaskInterface[]
     */
    public function findForRun(int $limit = null): array;
}
