<?php

namespace Fake\ChasterDtoBundle\Enums;

use Bytes\EnumSerializerBundle\Enums\StringBackedEnumInterface;
use Bytes\EnumSerializerBundle\Enums\StringBackedEnumTrait;

enum ChasterDtoActions: string implements StringBackedEnumInterface
{
    use StringBackedEnumTrait;

    case CREATE_LOCK = 'create-lock';
    case TIME = 'time';
    case PILLORY = 'pillory';
    case FREEZE = 'freeze';
    case UNFREEZE = 'unfreeze';
    case HIDE_TIMER = 'hide-timer';
    case SHOW_TIMER = 'show-timer';
    // case TASK = 'task';
    // case ADD_TASK_POINTS = 'add-task-points';
    // case REMOVE_TASK_POINTS = 'remove-task-points';
    // case ADD_SHARE_LINKS = 'add-share-links';
    // case REMOVE_SHARE_LINKS = 'remove-share-links';
}
