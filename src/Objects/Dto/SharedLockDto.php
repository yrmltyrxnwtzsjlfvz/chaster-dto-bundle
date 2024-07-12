<?php

namespace Fake\ChasterDtoBundle\Objects\Dto;

use Fake\ChasterObjects\Objects\Lock\SharedLock;
use Symfony\Component\Validator\Constraints as Assert;

class SharedLockDto extends SharedLock
{
    #[Assert\NotBlank]
    private ?string $photoId = null;

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
