<?php

namespace Bupy7\Queue\Test\Options;

use PHPUnit\Framework\TestCase;
use Bupy7\Queue\Options\ModuleOptions;
use Bupy7\Queue\Test\AppTrait;
use Queue\Hydrator\ArrayHydrator;

/**
 * @author Vasily Belosludcev <https://github.com/bupy7>
 */
class ModuleOptionsTest extends TestCase
{
    use AppTrait;

    public function testInstance()
    {
        $options = $this->getSm()->get('Bupy7\Queue\Options\ModuleOptions');
        $this->assertInstanceOf(ModuleOptions::class, $options);
    }

    public function testGet()
    {
        $options = $this->getSm()->get('Bupy7\Queue\Options\ModuleOptions');
        $this->assertEquals(100, $options->getOneTimeLimit());
        $this->assertEquals(5, $options->getErrorLimit());
    }

    public function testSet()
    {
        $options = $this->getSm()->get('Bupy7\Queue\Options\ModuleOptions');
        $options->setOneTimeLimit(-50);
        $this->assertEquals(0, $options->getOneTimeLimit());
        $options->setErrorLimit(-10);
        $this->assertEquals(0, $options->getErrorLimit());
    }

    public function testConfiguration()
    {
        $config = [
            'one_time_limit' => 32,
            'error_limit' => 10,
        ];
        $options = $this->getSm(['queue' => $config])->get('Bupy7\Queue\Options\ModuleOptions');
        $this->assertEquals(32, $options->getOneTimeLimit());
        $this->assertEquals(10, $options->getErrorLimit());
    }
}
