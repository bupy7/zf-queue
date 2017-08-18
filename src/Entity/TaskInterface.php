<?php

namespace Bupy7\Queue\Entity;

use DateTime;

/**
 * @author Vasily Belosludcev <https://github.com/bupy7>
 */
interface TaskInterface
{
    public const STATUS_WAIT = 10;
    public const STATUS_ERROR = 20;
    public const STATUS_OK = 30;
    public const STATUS_IMPOSSIBLE = 40;

    public function setId(int $id): TaskInterface;

    public function getId(): int;

    /**
     * Setting task command name for run.
     */
    public function setName(string $name): TaskInterface;

    /**
     * Getting task command name for run.
     */
    public function getName(): string;

    public function setStatusId(int $statusId): TaskInterface;

    public function getStatusId(): int;

    public function setCreatedAt(DateTime $createdAt): TaskInterface;

    public function getCreatedAt(): DateTime;

    public function setRunAt(DateTime $runAt): TaskInterface;

    public function getRunAt(): ?DateTime;

    public function setStopAt(DateTime $stopAt): TaskInterface;

    public function getStopAt(): ?DateTime;

    public function incNumberErrors(): TaskInterface;

    /**
     * Returns number errors by default 0.
     */
    public function getNumberErrors(): int;

    public function setParams(array $params): TaskInterface;

    public function getParams(): array;
}
