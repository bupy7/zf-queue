<?php

namespace Bupy7\Queue\Test\Assert\Entity;

use DateTime;
use InvalidArgumentException;
use Bupy7\Queue\Entity\TaskInterface;

/**
 * @author Vasily Belosludcev <https://github.com/bupy7>
 */
class Task implements TaskInterface
{
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
    /**
     * @var array
     */
    protected $params = [];

    public function __construct()
    {
        $this->createdAt = new DateTime;
    }

    public function setId(int $id): TaskInterface
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }
    
    public function setName(string $name): TaskInterface
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setStatusId(int $statusId): TaskInterface
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

    public function setCreatedAt(DateTime $createdAt): TaskInterface
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setRunAt(DateTime $runAt): TaskInterface
    {
        $this->runAt = $runAt;
        return $this;
    }

    public function getRunAt(): ?DateTime
    {
        return $this->runAt;
    }

    public function setStopAt(DateTime $stopAt): TaskInterface
    {
        $this->stopAt = $stopAt;
        return $this;
    }

    public function getStopAt(): ?DateTime
    {
        return $this->stopAt;
    }

    public function incNumberErrors(): TaskInterface
    {
        ++$this->numberErrors;
        return $this;
    }

    public function setNumberErrors(int $numberErrors): TaskInterface
    {
        $this->numberErrors = $numberErrors;
        return $this;
    }

    public function getNumberErrors(): int
    {
        return $this->numberErrors;
    }

    public function setParams(array $params): TaskInterface
    {
        $this->params = $params;
        return $this;
    }

    public function getParams(): array
    {
        return $this->params;
    }
}
