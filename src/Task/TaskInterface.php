<?php

namespace Bupy7\Queue\Task;

/**
 * @author Vasily Belosludcev <https://github.com/bupy7>
 */
interface TaskInterface
{
    public function execute(): bool;
}
