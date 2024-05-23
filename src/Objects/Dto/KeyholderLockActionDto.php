<?php

namespace Fake\ChasterDtoBundle\Objects\Dto;

use Fake\ChasterDtoBundle\Enums\ChasterDtoActions;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class KeyholderLockActionDto extends AbstractLockDto
{
    use KeyholderLockActionDtoTrait;

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
