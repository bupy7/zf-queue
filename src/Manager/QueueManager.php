<?php

namespace Bupy7\Queue\Manager;

use Bupy7\Queue\Task\TaskInterface;
use Laminas\ServiceManager\AbstractPluginManager;

/**
 * @author Vasily Belosludcev <https://github.com/bupy7>
 */
class QueueManager extends AbstractPluginManager
{
    protected $autoAddInvokableClass = false;
    protected $instanceOf = TaskInterface::class;
}
