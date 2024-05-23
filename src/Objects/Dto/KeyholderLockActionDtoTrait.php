<?php

namespace Fake\ChasterDtoBundle\Objects\Dto;

use Fake\ChasterObjects\Objects\Traits\LockIdTrait;
use Symfony\Component\Validator\Constraints as Assert;

trait KeyholderLockActionDtoTrait
{
    use LockDtoTrait;
    use LockActionDtoTrait;
    use LockIdTrait;

    #[Assert\When(
        expression: 'this.getAction() in [enum("Fake\\\ChasterDtoBundle\\\Enums\\\ChasterDtoActions::PILLORY")]',
        constraints: [
            new Assert\NotBlank(),
        ]
    )]
    private ?string $reason = null;

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
