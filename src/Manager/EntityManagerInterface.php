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
     * @throws \Bupy7\Queue\Exception\UnknownEntityException
     */
    public function newInstance(string $name);
    /**
     * @param object $entity
     */
    public function persist($entity): void;
    public function flush(): void;
}
