<?php

namespace Bupy7\Queue\Test\Assert\Service;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Bupy7\Queue\Service\TaskService;

/**
 * @author Vasily Belosludcev <https://github.com/bupy7>
 */
class MemoryTaskServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): TaskService
    {
        return new TaskService($container->get('DummyEntityManager'));
    }
}
