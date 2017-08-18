<?php

namespace Bupy7\Queue\Test;

use PHPUnit\Framework\TestCase;
use Zend\Test\Util\ModuleLoader;
use Bupy7\Queue\Module;

/**
 * @author Belosludcev Vasily <https://github.com/bupy7>
 */
class ModuleTest extends TestCase
{
    public function testLoader()
    {
        $moduleLoader = new ModuleLoader([
            'modules' => [
                'Zend\Router',
                'Bupy7\Queue',
            ],
            'module_listener_options' => [
                'module_paths' => [
                    __DIR__ . '/../src'
                ],
                'config_cache_enabled' => false,
                'module_map_cache_enabled' => false,
                'check_dependencies' => true,
            ],
        ]);
        $this->assertInstanceOf(Module::class, $moduleLoader->getModule('Bupy7\Queue'));
    }
}
