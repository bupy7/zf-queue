<?php

namespace Bupy7\Queue\Test;

return [
    'queue_manager' => [
        'factories' => [
            Assert\Task\ErrorHelloTask::class => \Zend\ServiceManager\Factory\InvokableFactory::class,
            Assert\Task\SuccessHelloTask::class => \Zend\ServiceManager\Factory\InvokableFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            'MemoryQueueService' => Assert\Service\MemoryQueueServiceFactory::class,
            Assert\Repository\MemoryTaskRepository::class => \Zend\ServiceManager\Factory\InvokableFactory::class,
            Assert\Manager\DummyEntityManager::class => \Zend\ServiceManager\Factory\InvokableFactory::class,
        ],
        'aliases' => [
            'MemoryTaskRepository' => Assert\Repository\MemoryTaskRepository::class,
            'DummyEntityManager' => Assert\Manager\DummyEntityManager::class,
        ],
    ],
];
