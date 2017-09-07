<?php

namespace QueueDoctrine;

return [
    'doctrine' => [
        'driver' => [
            'queue_entity' => [
                'class' => \Doctrine\ORM\Mapping\Driver\XmlDriver::class,
                'paths' => __DIR__ . '/mapping',
            ],
            'orm_default' => [
                'drivers' => [
                    'QueueDoctrine\Entity' => 'queue_entity',
                ],
            ],
        ],
    ],
];
