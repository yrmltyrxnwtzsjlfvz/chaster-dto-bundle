<?php

namespace Fake\ChasterDtoBundle\Objects\Dto;

use Bytes\DateBundle\Objects\ComparableDateInterval;
use DateInterval;
use Exception;
use Fake\ChasterDtoBundle\Enums\ChasterDtoActions;
use Fake\ChasterObjects\Objects\Interfaces\LockSessionInterface;
use Fake\ChasterObjects\Objects\Lock\LockId;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class WearerLockActionDto extends AbstractLockDto
{
    use WearerLockActionDtoTrait;

    public static function create(LockSessionInterface|string $lock, ChasterDtoActions $action,
        DateInterval|int|string|null $length = null, DateInterval|int|string|null $minLength = null,
        DateInterval|int|string|null $maxLength = null): static
    {
        $static = new static();

        return $static->setLockId(LockId::normalizeToLockId($lock))
            ->setAction($action)
            ->setLength($length)
            ->setMinLength($minLength)
            ->setMaxLength($maxLength);
    }

    /**
     * Returns a normalized array of key => value for data transfer.
     *
     * @return array{lockId: string|null, action: string|null, length: DateInterval|null, minLength: DateInterval|null, maxLength: DateInterval|null}
     *
     * @throws Exception
     */
    public function denormalize(): array
    {
        $return = parent::denormalize();

        if (!is_null($this->getLength())) {
            $return['length'] = ComparableDateInterval::normalizeToSeconds($this->getLength());
        }

        if (!is_null($this->getMinLength())) {
            $return['minLength'] = ComparableDateInterval::normalizeToSeconds($this->getMinLength());
        }

        if (!is_null($this->getMaxLength())) {
            $return['maxLength'] = ComparableDateInterval::normalizeToSeconds($this->getMaxLength());
        }

        return $return;
    }

    #[Assert\Callback]
    public function validate(ExecutionContextInterface $context, mixed $payload): void
    {
        if (!$this->getAction()?->equals(ChasterDtoActions::INCREASE_MAX_LIMIT_DATE, ChasterDtoActions::DISABLE_MAX_LIMIT_DATE, ChasterDtoActions::TRUST_KEYHOLDER)) {
            $context->buildViolation('This object requires the action be one of "INCREASE_MAX_LIMIT_DATE", "DISABLE_MAX_LIMIT_DATE", "TRUST_KEYHOLDER".')
                ->atPath('action')
                ->addViolation();
        }
    }
}
