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
            'length' => new DateInterval('PT5M'),
        ], $lock->denormalize());

        $lock = $class::create(lock: self::TEST_LOCKID, action: ChasterDtoActions::INCREASE_MAX_LIMIT_DATE, minLength: 300, maxLength: 600);

        $this->assertEquals([
            'lockId' => self::TEST_LOCKID,
            'action' => ChasterDtoActions::INCREASE_MAX_LIMIT_DATE->value,
            'minLength' => new DateInterval('PT5M'),
            'maxLength' => new DateInterval('PT10M'),
        ], $lock->denormalize());
    }
}
