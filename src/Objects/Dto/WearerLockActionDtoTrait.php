<?php

namespace Fake\ChasterDtoBundle\Objects\Dto;

use Fake\ChasterObjects\Objects\Traits\LockIdTrait;

trait WearerLockActionDtoTrait
{
    use LockDtoTrait;
    use LockActionDtoTrait;
    use LockIdTrait;
}
