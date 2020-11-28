<?php

namespace Bupy7\Queue\Test;

return [
    'queue_manager' => [
        'factories' => [
            Assert\Task\ErrorHelloTask::class => \Laminas\ServiceManager\Factory\InvokableFactory::class,
            Assert\Task\SuccessHelloTask::class => \Laminas\ServiceManager\Factory\InvokableFactory::class,
            Assert\Task\ExceptionHelloTask::class => \Laminas\ServiceManager\Factory\InvokableFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            'MemoryQueueService' => Assert\Service\MemoryQueueServiceFactory::class,

            Assert\Repository\MemoryTaskRepository::class => \Laminas\ServiceManager\Factory\InvokableFactory::class,
            Assert\Repository\MemoryExceptionTaskRepository::class
                => \Laminas\ServiceManager\Factory\InvokableFactory::class,

            Assert\Manager\DummyEntityManager::class => \Laminas\ServiceManager\Factory\InvokableFactory::class,
        ],
        'aliases' => [
            'DummyEntityManager' => Assert\Manager\DummyEntityManager::class,
        ],
    ],
];
