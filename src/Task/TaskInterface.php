<?php

namespace Bupy7\Queue\Task;

use Laminas\Stdlib\ParametersInterface;

/**
 * @author Vasily Belosludcev <https://github.com/bupy7>
 */
interface TaskInterface
{
    public function execute(ParametersInterface $params): bool;
}
