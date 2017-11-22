<?php

namespace Bupy7\Queue\Manager;

/**
 * @author Vasily Belosludcev <https://github.com/bupy7>
 */
interface EntityManagerInterface
{
    /**
     * @param string $name
     * @return object|null
     */
    public function newInstance(string $name);

    /**
     * @param object $entity
     */
    public function persist($entity): void;

    /**
     * @param object|null $entity
     */
    public function flush($entity = null): void;
}
