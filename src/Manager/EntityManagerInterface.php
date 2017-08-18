<?php

namespace Bupy7\Queue\Manager;

/**
 * @author Vasily Belosludcev <https://github.com/bupy7>
 */
interface EntityManagerInterface
{
    public function persist(object $entity): void;
    public function flush(): void;
}
