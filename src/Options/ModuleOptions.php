<?php

namespace Bupy7\Queue\Options;

use Zend\Stdlib\AbstractOptions;

/**
 * @author Vasily Belosludcev <https://github.com/bupy7>
 */
class ModuleOptions extends AbstractOptions
{
    /**
     * @var int The allowed limit to run tasks for a one time. If set as 0 - is no limit.
     */
    protected $oneTimeLimit = 100;
    /**
     * @var int The allowed error limit. After that a task status will is impossible done and don't will run again.
     * If set as 0 - is no limit.
     */
    protected $errorLimit = 5;

    public function setOneTimeLimit(int $oneTimeLimit): ModuleOptions
    {
        $this->oneTimeLimit = $oneTimeLimit;
        return $this;
    }

    public function getOneTimeLimit(): int
    {
        return $this->oneTimeLimit;
    }

    public function setErrorLimit(int $errorLimit): ModuleOptions
    {
        $this->errorLimit = $errorLimit;
        return $this;
    }

    public function getErrorLimit(): int
    {
        return $this->errorLimit;
    }
}
