<?php

namespace Fake\ChasterDtoBundle\Objects\Dto;

use DateTimeInterface;
use Fake\ChasterObjects\Enums\ActionLogType;
use Fake\ChasterObjects\Enums\ChasterExtension;
use Fake\ChasterObjects\Objects\Lock\ActionLog\PilloryInActionLog;
use Fake\ChasterObjects\Objects\Lock\ActionLog\PilloryOutActionLog;

class PilloryInOutDto
{
    private ?string $actionLogId = null;

    private ?string $lockId = null;

    private ?string $extension = null;

    private ?ActionLogType $actionLogType = null;

    private ?string $description = null;

    private ?string $reason = null;

    private ?int $duration = null;

    private ?int $timeAdded = null;

    private ?DateTimeInterface $createdAt = null;

    public function getActionLogId(): ?string
    {
        return $this->actionLogId;
    }

    /**
     * @return $this
     */
    public function setActionLogId(?string $actionLogId): static
    {
        $this->actionLogId = $actionLogId;

        return $this;
    }

    public function getLockId(): ?string
    {
        return $this->lockId;
    }

    /**
     * @return $this
     */
    public function setLockId(?string $lockId): static
    {
        $this->lockId = $lockId;

        return $this;
    }

    public function getExtension(): ?string
    {
        return $this->extension;
    }

    public function setExtension(ChasterExtension|string|null $extension): static
    {
        $this->extension = !is_null($extension) ? (ChasterExtension::tryNormalizeToValue($extension) ?? $extension) : $extension;

        return $this;
    }

    public function getActionLogType(): ?ActionLogType
    {
        return $this->actionLogType;
    }

    /**
     * @return $this
     */
    public function setActionLogType(ActionLogType|string|null $actionLogType): static
    {
        $this->actionLogType = is_null($actionLogType) ? null : ActionLogType::normalizeToEnum($actionLogType);

        return $this;
    }

    /**
     * @return $this
     */
    public static function create(PilloryInActionLog|PilloryOutActionLog $actionLog): static
    {
        $static = new static();
        $static->setActionLogId($actionLog->getId())
            ->setLockId($actionLog->getLock())
            ->setExtension($actionLog->getExtension())
            ->setActionLogType($actionLog->getType())
            ->setDescription($actionLog->getDescription())
            ->setCreatedAt($actionLog->getCreatedAt());

        if ($actionLog instanceof PilloryInActionLog) {
            $static->setReason($actionLog->getPayload()->getReason())
                ->setDuration($actionLog->getPayload()->getDuration());
        } else {
            $static->setTimeAdded($actionLog->getPayload()->getTimeAdded());
        }

        return $static;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return $this
     */
    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @return $this
     */
    public function setCreatedAt(?DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getReason(): ?string
    {
        return $this->reason;
    }

    /**
     * @return $this
     */
    public function setReason(?string $reason): static
    {
        $this->reason = $reason;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    /**
     * @return $this
     */
    public function setDuration(?int $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    public function getTimeAdded(): ?int
    {
        return $this->timeAdded;
    }

    /**
     * @return $this
     */
    public function setTimeAdded(?int $timeAdded): static
    {
        $this->timeAdded = $timeAdded;

        return $this;
    }
}
