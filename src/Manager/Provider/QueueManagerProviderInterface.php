<?php

namespace Bupy7\Queue\Manager\Provider;

/**
 * @author Vasily Belosludcev <https://github.com/bupy7>
 */
interface QueueManagerProviderInterface
{
    public function getQueueManagerConfig(): array;
}
