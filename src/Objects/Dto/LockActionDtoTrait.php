<?php

namespace Fake\ChasterDtoBundle\Objects\Dto;

use Bytes\DateBundle\Objects\ComparableDateInterval;
use DateInterval;
use Fake\ChasterDtoBundle\Enums\ChasterDtoActions;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

trait LockActionDtoTrait
{
    #[Assert\When(
        expression: 'this.getAction() in [enum("Fake\\\ChasterDtoBundle\\\Enums\\\ChasterDtoActions::TIME"), enum("Fake\\\ChasterDtoBundle\\\Enums\\\ChasterDtoActions::PILLORY"), enum("Fake\\\ChasterDtoBundle\\\Enums\\\ChasterDtoActions::INCREASE_MAX_LIMIT_DATE")]',
        constraints: [
            new Assert\NotNull(),
        ]
    )]
    protected ?DateInterval $length = null;

    protected ?DateInterval $minLength = null;

    protected ?DateInterval $maxLength = null;

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

    public function randomizeLength(): self
    {
        if (is_null($this->getLength()) && !(is_null($this->getMinLength()) || is_null($this->getMaxLength()))) {
            $min = ComparableDateInterval::getTotalMinutes($this->getMinLength(), 'floor');
            $max = ComparableDateInterval::getTotalMinutes($this->getMaxLength(), 'ceil');
            if ($min === $max) {
                $this->setLength($min * 60);
            } else {
                if ($min > $max) {
                    $temp = $max;
                    $max = $min;
                    $min = $temp;
                }

                $this->setLength(random_int($min, $max) * 60);
            }
        }

        return $this->setMinLength(null)
            ->setMaxLength(null);
    }
}
