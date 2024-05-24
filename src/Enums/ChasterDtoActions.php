<?php

namespace Fake\ChasterDtoBundle\Enums;

use Bytes\EnumSerializerBundle\Enums\StringBackedEnumInterface;
use Bytes\EnumSerializerBundle\Enums\StringBackedEnumTrait;
use Fake\ChasterDtoBundle\Objects\Dto\AbstractLockDto;
use Fake\ChasterDtoBundle\Objects\Dto\CreateLockDto;
use Fake\ChasterDtoBundle\Objects\Dto\KeyholderLockActionDto;
use Fake\ChasterDtoBundle\Objects\Dto\WearerLockActionDto;
use InvalidArgumentException;

enum ChasterDtoActions: string implements StringBackedEnumInterface
{
    use StringBackedEnumTrait;

    case TIME = 'time';
    case PILLORY = 'pillory';
    case FREEZE = 'freeze';
    case UNFREEZE = 'unfreeze';
    case HIDE_TIMER = 'hide-timer';
    case SHOW_TIMER = 'show-timer';
    case UNLOCK = 'unlock';
    case ARCHIVE = 'archive';

    case CREATE_LOCK = 'create-lock';
    case DISABLE_MAX_LIMIT_DATE = 'disable-max-limit-date';
    case INCREASE_MAX_LIMIT_DATE = 'increase-max-limit-date';
    case TRUST_KEYHOLDER = 'trust-keyholder';
    case TIME_WEARER = 'time-wearer';
    case UNLOCK_WEARER = 'unlock-wearer';
    case ARCHIVE_WEARER = 'archive-wearer';
    // case TASK = 'task';
    // case ADD_TASK_POINTS = 'add-task-points';
    // case REMOVE_TASK_POINTS = 'remove-task-points';
    // case ADD_SHARE_LINKS = 'add-share-links';
    // case REMOVE_SHARE_LINKS = 'remove-share-links';

    /**
     * @param class-string<AbstractLockDto> $dto
     *
     * @return ChasterDtoActions[]
     */
    public static function getAllowedActionsForDto(string $dto): array
    {
        switch ($dto) {
            case CreateLockDto::class:
                return [
                    ChasterDtoActions::CREATE_LOCK,
                ];
                break;
            case KeyholderLockActionDto::class:
                return [
                    ChasterDtoActions::TIME,
                    ChasterDtoActions::PILLORY,
                    ChasterDtoActions::FREEZE,
                    ChasterDtoActions::UNFREEZE,
                    ChasterDtoActions::HIDE_TIMER,
                    ChasterDtoActions::SHOW_TIMER,
                    ChasterDtoActions::UNLOCK,
                    ChasterDtoActions::ARCHIVE,
                ];
                break;
            case WearerLockActionDto::class:
                return [
                    ChasterDtoActions::DISABLE_MAX_LIMIT_DATE,
                    ChasterDtoActions::INCREASE_MAX_LIMIT_DATE,
                    ChasterDtoActions::TRUST_KEYHOLDER,
                    ChasterDtoActions::TIME_WEARER,
                    ChasterDtoActions::UNLOCK_WEARER,
                    ChasterDtoActions::ARCHIVE_WEARER,
                ];
                break;
        }

        throw new InvalidArgumentException();
    }
}
