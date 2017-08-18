<?php

namespace Bupy7\Queue\Manager;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * @author Vasily Belosludcev <https://github.com/bupy7>
 */
class QueueManagerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): QueueManager
    {
        return new QueueManager($container, $options ?: []);
    }
}
