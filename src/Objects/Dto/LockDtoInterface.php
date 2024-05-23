<?php

namespace Fake\ChasterDtoBundle\Objects\Dto;

use Fake\ChasterDtoBundle\Enums\ChasterDtoActions;
use Fake\ChasterObjects\Objects\Interfaces\LockSessionInterface;

interface LockDtoInterface extends LockSessionInterface
{
    public function getLockId(): ?string;

    /**
     * @return $this
     */
    public function setLockId(?string $lockId);

    public function getAction(): ?ChasterDtoActions;

    /**
     * @return $this
     */
    public function setAction(?ChasterDtoActions $action);

    public static function normalizeToLockId(LockSessionInterface|string $lock): string;
}
