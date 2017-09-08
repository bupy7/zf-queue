<?php

namespace QueueDoctrine;

return [
    'service_manager' => [
        'factories' => [
            Manager\EntityManager::class => \Zend\ServiceManager\AbstractFactory\ConfigAbstractFactory::class,
            \Bupy7\Queue\Service\QueueService::class => \QueueDoctrine\Service\QueueServiceFactory::class,
        ],
    ],
    \Zend\ServiceManager\AbstractFactory\ConfigAbstractFactory::class => [
        Manager\EntityManager::class => [
            \Doctrine\ORM\EntityManager::class,
        ],
    ],
];
