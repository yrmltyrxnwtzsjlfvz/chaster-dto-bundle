<?php

namespace Fake\ChasterDtoBundle\Objects\Dto;

use DateInterval;
use Fake\ChasterDtoBundle\Enums\ChasterDtoActions;
use Fake\ChasterObjects\Objects\Interfaces\LockSessionInterface;
use Fake\ChasterObjects\Objects\Lock\LockId;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class KeyholderLockActionDto extends AbstractLockDto
{
    use KeyholderLockActionDtoTrait;

    public static function create(LockSessionInterface|string $lock, ChasterDtoActions $action,
        DateInterval|int|string|null $length = null, DateInterval|int|string|null $minLength = null,
        DateInterval|int|string|null $maxLength = null, ?string $reason = null): static
    {
        $static = new static();

        return $static->setLockId(LockId::normalizeToLockId($lock))
            ->setAction($action)
            ->setLength($length)
            ->setMinLength($minLength)
            ->setMaxLength($maxLength)
            ->setReason($reason);
    }

    #[Assert\Callback]
    public function validate(ExecutionContextInterface $context, mixed $payload): void
    {
        if ($this->getAction()?->equals(ChasterDtoActions::CREATE_LOCK, ChasterDtoActions::INCREASE_MAX_LIMIT_DATE, ChasterDtoActions::DISABLE_MAX_LIMIT_DATE, ChasterDtoActions::TRUST_KEYHOLDER)) {
            $context->buildViolation('This object requires the action cannot be "CREATE_LOCK".')
                ->atPath('action')
                ->addViolation();
        }
    }
}
