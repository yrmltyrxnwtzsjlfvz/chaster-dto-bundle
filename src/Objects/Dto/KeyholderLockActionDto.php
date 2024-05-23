<?php

namespace Fake\ChasterDtoBundle\Objects\Dto;

use Bytes\DateBundle\Objects\ComparableDateInterval;
use Fake\ChasterDtoBundle\Enums\ChasterDtoActions;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class KeyholderLockActionDto extends AbstractLockDto
{
    use KeyholderLockActionDtoTrait;

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

    #[Assert\Callback]
    public function validate(ExecutionContextInterface $context, mixed $payload): void
    {
        $action = $this->getAction();
        if ($action?->equals(ChasterDtoActions::CREATE_LOCK)) {
            $context->buildViolation('This object requires the action cannot be "CREATE_LOCK".')
                ->atPath('action')
                ->addViolation();
        }
    }
}
