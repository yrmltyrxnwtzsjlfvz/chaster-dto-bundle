<?php

namespace Fake\ChasterDtoBundle\Tests\Objects\Dto;

use Fake\ChasterDtoBundle\Enums\ChasterDtoActions;
use Fake\ChasterDtoBundle\Objects\Dto\KeyholderLockActionDto;
use Symfony\Component\Validator\Exception\ValidationFailedException;

/**
 * @method static KeyholderLockActionDto createBasicDto()
 */
class KeyholderLockActionDtoTest extends AbstractTestLockActionDto
{
    public const TEST_REASON = 'Test Reason';

    /**
     * @return class-string<KeyholderLockActionDto>
     */
    public static function getTestClassName(): string
    {
        return KeyholderLockActionDto::class;
    }

    public function testWithInvalidAction(): void
    {
        $lock = self::createTestClass();
        $lock->setLockId(AbstractTestLockDto::TEST_LOCKID)
            ->setAction(ChasterDtoActions::CREATE_LOCK);

        $this->expectException(ValidationFailedException::class);

        $this->validate($lock);
    }

    public function testTimeWithLength()
    {
        $lock = self::createBasicDto()
            ->setAction(ChasterDtoActions::TIME)
            ->setLength(300);

        $this->assertEquals(1, $this->validate($lock));
    }

    public function testTimeWithoutLength()
    {
        $lock = self::createBasicDto()
            ->setAction(ChasterDtoActions::TIME);

        $this->expectException(ValidationFailedException::class);

        $this->validate($lock);
    }

    public function testPilloryWithLengthReason()
    {
        $lock = self::createBasicDto()
            ->setAction(ChasterDtoActions::PILLORY)
            ->setLength(300)
            ->setReason(self::TEST_REASON);

        $this->assertEquals(1, $this->validate($lock));
    }

    public function testPilloryWithLengthWithoutReason()
    {
        $lock = self::createBasicDto()
            ->setAction(ChasterDtoActions::PILLORY)
            ->setLength(300);

        $this->expectException(ValidationFailedException::class);

        $this->validate($lock);
    }

    public function testPilloryWithLengthBlankReason()
    {
        $lock = self::createBasicDto()
            ->setAction(ChasterDtoActions::PILLORY)
            ->setLength(300)
            ->setReason('');

        $this->expectException(ValidationFailedException::class);

        $this->validate($lock);
    }

    public function testGetAction(): void
    {
        $lock = self::createBasicDto();

        $this->assertNull($lock->getAction());
    }

    public function testPilloryWithoutLengthWithReason()
    {
        $lock = self::createBasicDto()
            ->setAction(ChasterDtoActions::PILLORY)
            ->setReason(self::TEST_REASON);

        $this->expectException(ValidationFailedException::class);

        $this->validate($lock);
    }

    public function testCreate(): void
    {
        $class = static::getTestClassName();
        $lock = $class::create(lock: self::TEST_LOCKID, action: ChasterDtoActions::INCREASE_MAX_LIMIT_DATE, length: 300);

        $this->assertInstanceOf(self::getTestClassName(), $lock);
    }

    public function testGetSetReason()
    {
        $lock = self::createBasicDto()
            ->setAction(ChasterDtoActions::PILLORY);

        $this->assertNull($lock->getReason());

        $lock->setReason(self::TEST_REASON);
        $this->assertEquals(self::TEST_REASON, $lock->getReason());
    }
}
