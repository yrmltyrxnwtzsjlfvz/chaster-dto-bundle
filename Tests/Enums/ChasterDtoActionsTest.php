<?php

namespace Fake\ChasterDtoBundle\Tests\Enums;

use Fake\ChasterDtoBundle\Enums\ChasterDtoActions;
use PHPUnit\Framework\TestCase;

class ChasterDtoActionsTest extends TestCase
{
    public function testEnum()
    {
        $this->assertTrue(ChasterDtoActions::CREATE_LOCK->equals(ChasterDtoActions::tryNormalizeToEnum('create-lock')));
    }
}
