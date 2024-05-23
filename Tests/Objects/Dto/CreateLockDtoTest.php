<?php

namespace Fake\ChasterDtoBundle\Tests\Objects\Dto;

use Fake\ChasterDtoBundle\Enums\ChasterDtoActions;
use Fake\ChasterDtoBundle\Objects\Dto\CreateLockDto;
use Symfony\Component\Validator\Exception\ValidationFailedException;

/**
 * @method static CreateLockDto createBasicDto()
 */
class CreateLockDtoTest extends AbstractTestLockDto
{
    public const TEST_PASSWORD = 'abc123';

    /**
     * @return class-string<CreateLockDto>
     */
    public static function getTestClassName(): string
    {
        return CreateLockDto::class;
    }

    /**
     * @dataProvider provideInvalidActions
     */
    public function testWithInvalidAction(ChasterDtoActions $action): void
    {
        $lock = self::createTestClass();
        $lock->setLockId(self::TEST_LOCKID)
            ->setAction($action);

        $this->expectException(ValidationFailedException::class);

        $this->validate($lock);
    }

    public function provideInvalidActions(): iterable
    {
        yield ['action' => ChasterDtoActions::TIME];
        yield ['action' => ChasterDtoActions::PILLORY];
        yield ['action' => ChasterDtoActions::FREEZE];
        yield ['action' => ChasterDtoActions::UNFREEZE];
        yield ['action' => ChasterDtoActions::HIDE_TIMER];
        yield ['action' => ChasterDtoActions::SHOW_TIMER];
    }

    /**
     * @dataProvider provideValidValues
     */
    public function testValid($password): void
    {
        $lock = self::createBasicDto()
            ->setPassword($password);

        $this->assertEquals(1, $this->validate($lock));
    }

    public function provideValidValues(): iterable
    {
        yield ['password' => self::TEST_PASSWORD];
        yield ['password' => null];
    }

    public function testGetSetPassword(): void
    {
        $lock = self::createBasicDto();

        $this->assertEquals(1, $this->validate($lock));

        $this->assertNull($lock->getPassword());

        $lock->setPassword(self::TEST_PASSWORD);
        $this->assertEquals(self::TEST_PASSWORD, $lock->getPassword());

        $lock->setPassword(null);
        $this->assertNull($lock->getPassword());
    }

    public function testGetAction(): void
    {
        $lock = self::createBasicDto();

        $this->assertEquals(ChasterDtoActions::CREATE_LOCK, $lock->getAction());
    }

    public function testInvalidPassword(): void
    {
        $lock = self::createBasicDto()
            ->setPassword('');

        $this->expectException(ValidationFailedException::class);

        $this->validate($lock);
    }
}
