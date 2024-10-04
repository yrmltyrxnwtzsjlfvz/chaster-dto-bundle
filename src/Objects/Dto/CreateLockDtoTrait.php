<?php

namespace Fake\ChasterDtoBundle\Objects\Dto;

use Fake\ChasterObjects\Objects\Traits\LockIdTrait;
use Symfony\Component\Validator\Constraints as Assert;

trait CreateLockDtoTrait
{
    use LockDtoTrait;
    use LockIdTrait;

    #[Assert\NotBlank(allowNull: true)]
    private ?string $password = null;

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }
}
