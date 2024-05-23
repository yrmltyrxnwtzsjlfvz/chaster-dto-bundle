<?php

namespace Fake\ChasterDtoBundle\Objects\Dto;

use Fake\ChasterObjects\Objects\Traits\LockIdTrait;
use Symfony\Component\Validator\Constraints as Assert;

trait WearerLockActionDtoTrait
{
    use LockDtoTrait;
    use LockActionDtoTrait;
    use LockIdTrait;
}
