<?php

namespace Fake\ChasterDtoBundle\Objects\Dto;

use Fake\ChasterDtoBundle\Enums\ChasterDtoActions;
use Fake\ChasterObjects\Objects\Traits\LockIdTrait;
use Symfony\Component\Serializer\Annotation\DiscriminatorMap;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[DiscriminatorMap(typeProperty: 'actionString', mapping: [
    'create-lock' => CreateLockDto::class,
    'disable-max-limit-date' => WearerLockActionDto::class,
    'increase-max-limit-date' => WearerLockActionDto::class,
    'trust-keyholder' => WearerLockActionDto::class,
    'time' => KeyholderLockActionDto::class,
    'pillory' => KeyholderLockActionDto::class,
    'freeze' => KeyholderLockActionDto::class,
    'unfreeze' => KeyholderLockActionDto::class,
    'task' => KeyholderLockActionDto::class,
    'hide-timer' => KeyholderLockActionDto::class,
    'show-timer' => KeyholderLockActionDto::class,
    'add-task-points' => KeyholderLockActionDto::class,
    'remove-task-points' => KeyholderLockActionDto::class,
    'add-share-links' => KeyholderLockActionDto::class,
    'remove-share-links' => KeyholderLockActionDto::class,
])]
abstract class AbstractLockDto implements LockDtoInterface
{
    use LockIdTrait;
    use LockDtoTrait;

    private ?string $actionString = null;

    public function getActionString(): ?string
    {
        return $this->actionString;
    }

    public function setActionString(?string $actionString): self
    {
        $this->actionString = $actionString;

        return $this;
    }

    public function setAction(?ChasterDtoActions $action): self
    {
        $this->action = $action;
        $this->actionString = !is_null($this->action) ? ChasterDtoActions::normalizeToValue($action) : null;

        return $this;
    }

    abstract public function validate(ExecutionContextInterface $context, mixed $payload): void;
}
