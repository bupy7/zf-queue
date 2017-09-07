<?php

namespace QueueDoctrine\Service;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Bupy7\Queue\Service\QueueService;

class QueueServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): QueueService
    {
        return new QueueService(
            $container->get('QueueDoctrine\Repository\TaskRepository'),
            $container->get('QueueDoctrine\Manager\EntityManager'),
            $container->get('Bupy7\Queue\Manager\QueueManager'),
            $container->get('Bupy7\Queue\Options\ModuleOptions')
        );
    }
}
