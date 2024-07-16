<?php

namespace Fake\ChasterDtoBundle\Objects\Dto;

use DateTimeInterface;
use Fake\ChasterObjects\Objects\Lock\SharedLock;
use Symfony\Component\Validator\Constraints as Assert;

class SharedLockDto extends SharedLock
{
    #[Assert\NotBlank]
    private ?string $photoId = null;

    public function getPhotoId(): ?string
    {
        return $this->photoId;
    }

    public function setPhotoId(?string $photoId): static
    {
        $this->photoId = $photoId;

        return $this;
    }

    public function hasDurations(): bool
    {
        return ($this->getMinDuration() ?? 0) > 0 || ($this->getMaxDuration() ?? 0) > 0 || ($this->getMaxLimitDuration() ?? 0) > 0;
    }

    public function hasDates(): bool
    {
        return !is_null($this->getMinDate()) || !is_null($this->getMaxDate()) || !is_null($this->getMaxLimitDate());
    }

    public static function create(string $lockId, bool $displayRemainingTime = true, ?string $photoId = null, ?int $minDuration = 1,
        ?int $maxDuration = 1, ?int $maxLimitDuration = null, ?DateTimeInterface $minDate = null, ?DateTimeInterface $maxDate = null,
        ?DateTimeInterface $maxLimitDate = null, array $tags = []): static
    {
        return (new static())
            ->setId($lockId)
            ->setDisplayRemainingTime($displayRemainingTime)
            ->setHideTimeLogs(!$displayRemainingTime)
            ->setTags($tags)
            ->setMinDuration($minDuration)
            ->setMaxDuration($maxDuration)
            ->setMaxLimitDuration($maxLimitDuration)
            ->setMinDate($minDate)
            ->setMaxDate($maxDate)
            ->setMaxLimitDate($maxLimitDate)
            ->setLimitLockTime(!is_null($maxLimitDate) || !empty($maxLimitDuration))
            ->setPhotoId($photoId);
    }
}
