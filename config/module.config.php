<?php

namespace Bupy7\Queue;

return [
    'queue' => [],
    'queue_manager' => [],
    'service_manager' => [
        'factories' => [
            Manager\QueueManager::class => Manager\QueueManagerFactory::class,
            Options\ModuleOptions::class => Options\ModuleOptionsFactory::class,
        ],
    ],
];
