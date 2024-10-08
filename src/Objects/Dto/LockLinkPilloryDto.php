<?php

namespace Fake\ChasterDtoBundle\Objects\Dto;

use Fake\ChasterObjects\Objects\Extension\Link\LinkInfo;
use Fake\ChasterObjects\Objects\Lock;
use Fake\ChasterObjects\Objects\Lock\PilloryStatus;

class LockLinkPilloryDto
{
    private ?Lock $lock = null;

    /**
     * @var PilloryStatus[]
     */
    private array $pillories = [];

    private ?LinkInfo $link = null;

    public function getLock(): ?Lock
    {
        return $this->lock;
    }

    /**
     * @return $this
     */
    public function setLock(?Lock $lock): static
    {
        $this->lock = $lock;

        return $this;
    }

    /**
     * @return PilloryStatus[]
     */
    public function getPillories(): array
    {
        return $this->pillories;
    }

    /**
     * @param PilloryStatus[] $pillories
     *
     * @return $this
     */
    public function setPillories(array $pillories): static
    {
        $this->pillories = $pillories;

        return $this;
    }

    public function getLink(): ?LinkInfo
    {
        return $this->link;
    }

    /**
     * @return $this
     */
    public function setLink(?LinkInfo $link): static
    {
        $this->link = $link;

        return $this;
    }
}
