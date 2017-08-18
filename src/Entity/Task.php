<?php

namespace Bupy7\Queue\Entity;

use DateTime;
use Bupy7\Queue\Exception\InvalidArgumentException;

/**
 * @author Vasily Belosludcev <https://github.com/bupy7>
 */
class Task
{
    public const STATUS_WAIT = 10;
    public const STATUS_ERROR = 20;
    public const STATUS_OK = 30;
    public const STATUS_IMPOSSIBLE = 40;

    /**
     * @var int
     */
    protected $id;
    /**
     * @var string Task command name for run.
     */
    protected $name;
    /**
     * @var int
     */
    protected $statusId = self::STATUS_WAIT;
    /**
     * @var DateTime
     */
    protected $createdAt;
    /**
     * @var DateTime|null
     */
    protected $runAt;
    /**
     * @var DateTime|null
     */
    protected $stopAt;
    /**
     * @var int
     */
    protected $numberErrors = 0;

    public function __construct()
    {
        $this->createdAt = new DateTime;
    }

    public function setId(int $id): Task
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }
    
    public function setName(string $name): Task
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setStatusId(int $statusId): Task
    {
        if (!in_array($statusId, [
            self::STATUS_WAIT,
            self::STATUS_ERROR,
            self::STATUS_OK,
            self::STATUS_IMPOSSIBLE,
        ])) {
            throw new InvalidArgumentException('"statusId" is invalid.');
        }
        $this->statusId = $statusId;
        return $this;
    }

    public function getStatusId(): int
    {
        return $this->statusId;
    }

    public function setCreatedAt(DateTime $createdAt): Task
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setRunAt(DateTime $runAt): Task
    {
        $this->runAt = $runAt;
        return $this;
    }

    public function getRunAt(): ?DateTime
    {
        return $this->runAt;
    }

    public function setStopAt(DateTime $stopAt): Task
    {
        $this->stopAt = $stopAt;
        return $this;
    }

    public function getStopAt(): ?DateTime
    {
        return $this->stopAt;
    }

    public function incNumberErrors(int $inc = 1): Task
    {
        $this->numberErrors += $inc;
        return $this;
    }

    public function getNumberErrors(): int
    {
        return $this->numberErrors;
    }
}
