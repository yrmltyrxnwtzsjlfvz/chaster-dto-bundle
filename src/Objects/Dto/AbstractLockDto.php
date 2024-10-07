<?php

namespace Fake\ChasterDtoBundle\Objects\Dto;

use Fake\ChasterDtoBundle\Enums\ChasterDtoActions;
use Fake\ChasterObjects\Objects\Traits\LockIdTrait;
use Symfony\Component\Serializer\Annotation\DiscriminatorMap;
use Symfony\Component\Serializer\Attribute\Context;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[Context([AbstractObjectNormalizer::SKIP_NULL_VALUES => true])]
#[DiscriminatorMap(typeProperty: 'actionString', mapping: [
    'time' => KeyholderLockActionDto::class,
    'pillory' => KeyholderLockActionDto::class,
    'freeze' => KeyholderLockActionDto::class,
    'unfreeze' => KeyholderLockActionDto::class,
    'hide-timer' => KeyholderLockActionDto::class,
    'show-timer' => KeyholderLockActionDto::class,
    'unlock' => KeyholderLockActionDto::class,
    'temporary-unlock' => KeyholderLockActionDto::class,
    'temporary-relock' => KeyholderLockActionDto::class,
    'archive' => KeyholderLockActionDto::class,
    'create-lock' => CreateLockDto::class,
    'disable-max-limit-date' => WearerLockActionDto::class,
    'increase-max-limit-date' => WearerLockActionDto::class,
    'trust-keyholder' => WearerLockActionDto::class,
    'time-wearer' => WearerLockActionDto::class,
    'unlock-wearer' => WearerLockActionDto::class,
    'temporary-unlock-wearer' => WearerLockActionDto::class,
    'temporary-relock-wearer' => WearerLockActionDto::class,
    'archive-wearer' => WearerLockActionDto::class,
    'hide-timer-wearer' => KeyholderLockActionDto::class,
    'show-timer-wearer' => KeyholderLockActionDto::class,
    'complete-task-wearer' => WearerLockActionDto::class,
    'abandon-task-wearer' => WearerLockActionDto::class,
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

    /**
     * Returns a normalized array of key => value for data transfer.
     */
    public function denormalize(): array
    {
        return [
            'lockId' => $this->getLockId(),
            'action' => $this->getAction()?->value,
        ];
    }
}
