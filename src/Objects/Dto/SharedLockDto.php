<?php

namespace Fake\ChasterDtoBundle\Objects\Dto;

use Fake\ChasterObjects\Objects\Lock\SharedLock;
use SensitiveParameter;
use Symfony\Component\Validator\Constraints as Assert;

class SharedLockDto extends SharedLock
{
    #[Assert\NotBlank]
    private ?string $password = null;

    #[Assert\NotBlank]
    private ?string $photoId = null;

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(#[SensitiveParameter] ?string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Helper method that sets the password and requirePassword fields.
     *
     * @param string|null $password
     *
     * @return $this
     */
    public function setPasswordRequired(#[SensitiveParameter] ?string $password = null): static
    {
        return $this->setPassword($password)
            ->setRequirePassword(!empty($password));
    }

    public function getPhotoId(): ?string
    {
        return $this->photoId;
    }

    public function setPhotoId(?string $photoId): static
    {
        $this->photoId = $photoId;
        return $this;
    }
}
