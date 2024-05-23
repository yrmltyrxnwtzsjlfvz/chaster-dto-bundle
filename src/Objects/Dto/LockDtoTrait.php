<?php

namespace Fake\ChasterDtoBundle\Objects\Dto;

use Fake\ChasterDtoBundle\Enums\ChasterDtoActions;
use Fake\ChasterObjects\Objects\Traits\LockIdNormalizerTrait;

trait LockDtoTrait
{
    use LockIdNormalizerTrait;

    protected ?ChasterDtoActions $action = null;

    public function getAction(): ?ChasterDtoActions
    {
        return $this->action;
    }
}
