<?php

namespace Bupy7\Queue\Test\Assert\Task;

use Bupy7\Queue\Task\TaskInterface;

/**
 * @author Vasily Belosludcev <https://github.com/bupy7>
 */
class ErrorHelloTask implements TaskInterface
{
    public function execute(): bool
    {
        return false;
    }
}
