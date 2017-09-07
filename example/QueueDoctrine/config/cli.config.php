<?php

namespace QueueDoctrine;

return [
    'cli' => [
        'commands' => [
            Command\RunCommand::class,
        ],
    ],
    'command_manager' => [
        'factories' => [
            Command\RunCommand::class => \Zend\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory::class,
        ],
    ],
];
