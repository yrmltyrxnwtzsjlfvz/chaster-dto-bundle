<?php

namespace Fake\ChasterDtoBundle\Objects\Dto;

use Fake\ChasterDtoBundle\Enums\ChasterDtoActions;
use Fake\ChasterObjects\Objects\Interfaces\LockSessionInterface;
use Fake\ChasterObjects\Objects\Lock\LockId;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class CreateLockDto extends AbstractLockDto
{
    use CreateLockDtoTrait;

    public function __construct()
    {
        $this->setAction(ChasterDtoActions::CREATE_LOCK);
    }

    public static function create(LockSessionInterface|string $lock, ?string $password = null): static
    {
        $static = new static();

        return $static->setLockId(LockId::normalizeToLockId($lock))
            ->setPassword($password);
    }

    #[Assert\Callback]
    public function validate(ExecutionContextInterface $context, mixed $payload): void
    {
        if (!$this->getAction()?->equals(...ChasterDtoActions::getAllowedActionsForDto(static::class))) {
            $context->buildViolation('This object requires the action to be "CREATE_LOCK".')
                ->atPath('action')
                ->addViolation();
        }
    }

    /**
     * Returns a normalized array of key => value for data transfer.
     *
     * @return array{lockId: string|null, action: string|null, password: string|null}
     */
    public function denormalize(): array
    {
        $return = parent::denormalize();

        if (!is_null($this->getPassword())) {
            $return['password'] = $this->getPassword();
        }

        return $return;
    }
}
