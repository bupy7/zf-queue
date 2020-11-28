<?php

namespace QueueDoctrine;

use Laminas\ModuleManager\Feature\ConfigProviderInterface;
use Laminas\ModuleManager\Feature\BootstrapListenerInterface;
use Laminas\EventManager\EventInterface;
use QueueDoctrine\Type\ParamsType;
use Doctrine\DBAL\Types\Type;

class Module implements ConfigProviderInterface, BootstrapListenerInterface
{
    public function getConfig(): array
    {
        return array_merge(
            require __DIR__ . '/../config/module.config.php',
            require __DIR__ . '/../config/doctrine.config.php'
        );
    }

    public function onBootstrap(EventInterface $e)
    {
        if (!Type::hasType(ParamsType::PARAMS)) {
            Type::addType(ParamsType::PARAMS, ParamsType::class);
        }
    }
}
