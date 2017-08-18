<?php

namespace Bupy7\Queue\Test;

use Zend\ServiceManager\ServiceManager;
use Zend\Test\Util\ModuleLoader;

/**
 * @author Vasily Belosludcev <https://github.com/bupy7>
 */
trait AppTrait
{
    protected function getSm(): ServiceManager
    {
        $moduleLoader = new ModuleLoader([
            'modules' => [
                'Zend\Router',
                'Bupy7\Queue',
            ],
            'module_listener_options' => [
                'config_glob_paths' => [
                    __DIR__ . '/../config/module.config.php',
                    __DIR__ . '/config/module.config.php',
                ],
                'module_paths' => [],
                'config_cache_enabled' => false,
                'module_map_cache_enabled' => false,
                'check_dependencies' => true,
            ],
        ]);
        return $moduleLoader->getServiceManager();
    }
}
