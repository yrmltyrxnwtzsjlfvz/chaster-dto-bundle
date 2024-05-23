<?php

namespace Fake\ChasterDtoBundle\Objects\Dto;

use Bytes\DateBundle\Objects\ComparableDateInterval;
use DateInterval;
use Fake\ChasterObjects\Objects\Traits\LockIdTrait;
use Symfony\Component\Validator\Constraints as Assert;

trait KeyholderLockActionDtoTrait
{
    use LockDtoTrait;
    use LockIdTrait;

    #[Assert\When(
        expression: 'this.getAction() in [enum("Fake\\\ChasterDtoBundle\\\Enums\\\ChasterDtoActions::TIME"), enum("Fake\\\ChasterDtoBundle\\\Enums\\\ChasterDtoActions::PILLORY")]',
        constraints: [
            new Assert\NotNull(),
        ]
    )]
    private ?DateInterval $length = null;

    private ?DateInterval $minLength = null;

    private ?DateInterval $maxLength = null;

    #[Assert\When(
        expression: 'this.getAction() in [enum("Fake\\\ChasterDtoBundle\\\Enums\\\ChasterDtoActions::PILLORY")]',
        constraints: [
            new Assert\NotBlank(),
        ]
    )]
    private ?string $reason = null;

    public function getLength(): ?DateInterval
    {
        return $this->length;
    }

    public function setLength(DateInterval|int|string|null $length): self
    {
        $this->length = !is_null($length) ? ComparableDateInterval::normalizeToDateInterval($length) : null;

        return $this;
    }

    public function getMinLength(): ?DateInterval
    {
        return $this->minLength;
    }

    public function setMinLength(DateInterval|int|string|null $minLength): self
    {
        $this->minLength = !is_null($minLength) ? ComparableDateInterval::normalizeToDateInterval($minLength) : null;

        return $this;
    }

    public function getMaxLength(): ?DateInterval
    {
        return $this->maxLength;
    }

    public function setMaxLength(DateInterval|int|string|null $maxLength): self
    {
        $this->maxLength = !is_null($maxLength) ? ComparableDateInterval::normalizeToDateInterval($maxLength) : null;

        return $this;
    }

    public function getReason(): ?string
    {
        return $this->reason;
    }

    public function setReason(?string $reason): self
    {
        $this->reason = $reason;

        return $this;
    }
}
