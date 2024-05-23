<?php

namespace Fake\ChasterDtoBundle\Objects\Dto;

use Fake\ChasterDtoBundle\Enums\ChasterDtoActions;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class WearerLockActionDto extends AbstractLockDto
{
    use WearerLockActionDtoTrait;

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
