<?php

namespace Bupy7\Queue\Test\Assert\Task;

use Bupy7\Queue\Task\TaskInterface;
use Zend\Stdlib\ParametersInterface;
use Exception;

/**
 * @author Vasily Belosludcev <https://github.com/bupy7>
 */
class ExceptionHelloTask implements TaskInterface
{
    public function execute(ParametersInterface $params): bool
    {
        throw new Exception('Some exception error');
    }
}
