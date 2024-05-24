<?php

namespace Fake\ChasterDtoBundle\Tests\Objects\Dto;

use DateInterval;
use Fake\ChasterDtoBundle\Enums\ChasterDtoActions;
use Fake\ChasterDtoBundle\Objects\Dto\WearerLockActionDto;
use Symfony\Component\Validator\Exception\ValidationFailedException;

/**
 * @method static WearerLockActionDto createBasicDto()
 */
class WearerLockActionDtoTest extends AbstractTestLockActionDto
{
    public const TEST_REASON = 'Test Reason';

    /**
     * @return class-string<WearerLockActionDto>
     */
    public static function getTestClassName(): string
    {
        return WearerLockActionDto::class;
    }

    public function testWithInvalidAction(): void
    {
        $lock = self::createTestClass();
        $lock->setLockId(AbstractTestLockDto::TEST_LOCKID)
            ->setAction(ChasterDtoActions::CREATE_LOCK);

        $this->expectException(ValidationFailedException::class);

        $this->validate($lock);
    }

    public function testIncreaseWithLength()
    {
        $lock = self::createBasicDto()
            ->setAction(ChasterDtoActions::INCREASE_MAX_LIMIT_DATE)
            ->setLength(300);

        $this->assertEquals(1, $this->validate($lock));
    }

    public function testIncreaseWithoutLength()
    {
        $lock = self::createBasicDto()
            ->setAction(ChasterDtoActions::INCREASE_MAX_LIMIT_DATE);

        $this->expectException(ValidationFailedException::class);

        $this->validate($lock);
    }

    public function testGetAction(): void
    {
        $lock = self::createBasicDto();

        $this->assertNull($lock->getAction());
    }

    public function testCreate(): void
    {
        $class = static::getTestClassName();
        $lock = $class::create(lock: self::TEST_LOCKID, action: ChasterDtoActions::INCREASE_MAX_LIMIT_DATE, length: 300);

        $this->assertInstanceOf(self::getTestClassName(), $lock);
    }

    public function testDenormalize(): void
    {
        $class = static::getTestClassName();
        $lock = $class::create(lock: self::TEST_LOCKID, action: ChasterDtoActions::INCREASE_MAX_LIMIT_DATE, length: 300);

        $this->assertEquals([
            'lockId' => self::TEST_LOCKID,
            'action' => ChasterDtoActions::INCREASE_MAX_LIMIT_DATE->value,
            'length' => 300,
        ], $lock->denormalize());

        $lock = $class::create(lock: self::TEST_LOCKID, action: ChasterDtoActions::INCREASE_MAX_LIMIT_DATE, minLength: 300, maxLength: new DateInterval('PT10M'));

        $this->assertEquals([
            'lockId' => self::TEST_LOCKID,
            'action' => ChasterDtoActions::INCREASE_MAX_LIMIT_DATE->value,
            'minLength' => 300,
            'maxLength' => 600,
        ], $lock->denormalize());
    }


    public function testIncreaseTime()
    {
        $lock = self::createBasicDto()
            ->setAction(ChasterDtoActions::TIME_WEARER)
            ->setLength(300);

        $this->assertEquals(1, $this->validate($lock));
    }

    public function testIncreaseTimeRandom()
    {
        $lock = self::createBasicDto()
            ->setAction(ChasterDtoActions::TIME_WEARER)
            ->setMinLength(300)
            ->setMaxLength(600)
            ->randomizeLength();

        $this->assertEquals(1, $this->validate($lock));
    }

    public function testIncreaseTimeNoLength()
    {
        $lock = self::createBasicDto()
            ->setAction(ChasterDtoActions::TIME_WEARER);

        $this->expectException(ValidationFailedException::class);

        $this->validate($lock);
    }

    public function testDecreaseTime()
    {
        $lock = self::createBasicDto()
            ->setAction(ChasterDtoActions::TIME_WEARER)
        ->setLength(-300);

        $this->expectException(ValidationFailedException::class);

        $this->validate($lock);
    }

    public function testDecreaseTimeRandom()
    {
        $lock = self::createBasicDto()
            ->setAction(ChasterDtoActions::TIME_WEARER)
            ->setMinLength(-300)
            ->setMaxLength(-600)
            ->randomizeLength();

        $this->expectException(ValidationFailedException::class);

        $this->validate($lock);
    }
}
