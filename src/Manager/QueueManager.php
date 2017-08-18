<?php

namespace Bupy7\Queue\Manager;

use Bupy7\Queue\Task\TaskInterface;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\EventManager\EventManagerAwareInterface;
use Interop\Container\ContainerInterface;

/**
 * @author Vasily Belosludcev <https://github.com/bupy7>
 */
class QueueManager extends AbstractPluginManager
{
    protected $autoAddInvokableClass = false;
    protected $instanceOf = TaskInterface::class;

    public function __construct($configOrContainerInstance, array $config = [])
    {
        $this->addInitializer([$this, 'injectEventManager']);
        parent::__construct($configOrContainerInstance, $config);
    }

    public function injectEventManager(ContainerInterface $container, TaskInterface $task)
    {
        if (!$task instanceof EventManagerAwareInterface) {
            return;
        }
        if (!$task->getEventManager()) {
            $task->setEventManager($container->get('EventManager'));
        }
    }
}
