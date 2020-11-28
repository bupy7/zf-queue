<?php

namespace Bupy7\Queue\Test\Functional;

use Laminas\ServiceManager\ServiceManager;
use Laminas\Test\Util\ModuleLoader;

/**
 * @author Vasily Belosludcev <https://github.com/bupy7>
 */
trait AppTrait
{
    protected function getSm(array $config = []): ServiceManager
    {
        $moduleLoader = new ModuleLoader([
            'modules' => [
                'Laminas\Router',
                'Bupy7\Queue',
            ],
            'module_listener_options' => [
                'config_glob_paths' => [
                    __DIR__ . '/_file/config/module.config.php',
                ],
                'extra_config' => $config,
                'module_paths' => [],
                'config_cache_enabled' => false,
                'module_map_cache_enabled' => false,
                'check_dependencies' => true,
            ],
        ]);
        return $moduleLoader->getServiceManager();
    }
}
