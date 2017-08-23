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
            'MemoryTaskService' => Assert\Service\MemoryTaskServiceFactory::class,

            Assert\Repository\MemoryTaskRepository::class => \Zend\ServiceManager\Factory\InvokableFactory::class,
            Assert\Repository\MemoryExceptionTaskRepository::class
                => \Zend\ServiceManager\Factory\InvokableFactory::class,

            Assert\Manager\DummyEntityManager::class => \Zend\ServiceManager\Factory\InvokableFactory::class,
        ],
        'aliases' => [
            'DummyEntityManager' => Assert\Manager\DummyEntityManager::class,
        ],
    ],
];
