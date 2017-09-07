<?php

namespace QueueDoctrine\Service;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Bupy7\Queue\Service\TaskService;

class TaskServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): TaskService
    {
        return new TaskService($container->get('QueueDoctrine\Manager\EntityManager'));
    }
}
