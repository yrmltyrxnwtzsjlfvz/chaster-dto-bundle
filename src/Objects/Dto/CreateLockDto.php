<?php

namespace Fake\ChasterDtoBundle\Objects\Dto;

use Fake\ChasterDtoBundle\Enums\ChasterDtoActions;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class CreateLockDto extends AbstractLockDto
{
    use CreateLockDtoTrait;

    public function __construct()
    {
        $this->setAction(ChasterDtoActions::CREATE_LOCK);
    }

    #[Assert\Callback]
    public function validate(ExecutionContextInterface $context, mixed $payload): void
    {
        if (!$this->getAction()?->equals(ChasterDtoActions::CREATE_LOCK)) {
            $context->buildViolation('This object requires the action to be "CREATE_LOCK".')
                ->atPath('action')
                ->addViolation();
        }
    }
}
