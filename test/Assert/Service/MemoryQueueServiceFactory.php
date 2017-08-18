<?php

namespace Bupy7\Queue\Test\Assert\Service;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Bupy7\Queue\Service\QueueService;

/**
 * @author Vasily Belosludcev <https://github.com/bupy7>
 */
class MemoryQueueServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): QueueService
    {
        return new QueueService(
            $container->get('MemoryTaskRepository'),
            $container->get('DummyEntityManager'),
            $container->get('Bupy7\Queue\Manager\QueueManager'),
            $container->get('Bupy7\Queue\Options\ModuleOptions')
        );
    }
}
