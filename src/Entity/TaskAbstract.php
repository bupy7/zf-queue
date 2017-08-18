<?php

namespace Bupy7\Queue\Entity;

use DateTime;
use Bupy7\Queue\Exception\InvalidArgumentException;

/**
 * @author Vasily Belosludcev <https://github.com/bupy7>
 */
abstract class TaskAbstract
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
    protected $statusId;
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
    
    public function getId(): int
    {
        return $this->id;
    }
    
    public function setName(string $name): TaskAbstract
    {
        $this->name = $name;
    }

    /**
     * Getting task command name for run.
     */
    public function getName(): string
    {
        return $this->name;
    }

    public function setStatusId(int $statusId): TaskAbstract
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
    }

    public function getStatusId(): int
    {
        return $this->statusId;
    }

    public function setCreatedAt(DateTime $createdAt): TaskAbstract
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setRunAt(DateTime $runAt): TaskAbstract
    {
        $this->runAt = $runAt;
        return $this;
    }

    public function getRunAt(): ?DateTime
    {
        return $this->runAt;
    }

    public function setStopAt(DateTime $stopAt): TaskAbstract
    {
        $this->stopAt = $stopAt;
        return $this;
    }

    public function getStopAt(): ?DateTime
    {
        return $this->stopAt;
    }

    public function incNumberErrors(): TaskAbstract
    {
        ++$this->numberErrors;
        return $this;
    }

    public function getNumberErrors(): int
    {
        return $this->numberErrors;
    }
}
