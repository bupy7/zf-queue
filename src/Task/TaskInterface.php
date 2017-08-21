<?php

namespace Bupy7\Queue\Task;

use Zend\Stdlib\ParametersInterface;

/**
 * @author Vasily Belosludcev <https://github.com/bupy7>
 */
interface TaskInterface
{
    public function execute(ParametersInterface $params): bool;
}
