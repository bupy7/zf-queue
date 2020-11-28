<?php

namespace QueueDoctrine\Service;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Bupy7\Queue\Service\QueueService;

class QueueServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): QueueService
    {
        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $container->get('Doctrine\ORM\EntityManager');
        return new QueueService(
            $em->getRepository('QueueDoctrine\Entity\Task'),
            $container->get('QueueDoctrine\Manager\EntityManager'),
            $container->get('Bupy7\Queue\Manager\QueueManager'),
            $container->get('Bupy7\Queue\Options\ModuleOptions')
        );
    }
}
