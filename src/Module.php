<?php

namespace Bupy7\Queue;

use Laminas\ModuleManager\Feature\ConfigProviderInterface;
use Laminas\ModuleManager\Feature\InitProviderInterface;
use Laminas\ModuleManager\ModuleManagerInterface;

/**
 * @author Vasily Belosludcev <https://github.com/bupy7>
 */
class Module implements ConfigProviderInterface, InitProviderInterface
{
    public function getConfig(): array
    {
        return require __DIR__ . '/../config/module.config.php';
    }

    public function init(ModuleManagerInterface $manager)
    {
        $event = $manager->getEvent();
        $container = $event->getParam('ServiceManager');
        /** @var \Laminas\ModuleManager\Listener\ServiceListener $serviceListener */
        $serviceListener = $container->get('ServiceListener');
        $serviceListener->addServiceManager(
            'Bupy7\Queue\Manager\QueueManager',
            'queue_manager',
            'Bupy7\Queue\Manager\Provider\QueueManagerProviderInterface',
            'getQueueManagerConfig'
        );
    }
}
