<?php

namespace Fake\ChasterDtoBundle\Tests\Objects\Dto;

use Fake\ChasterDtoBundle\Enums\ChasterDtoActions;
use Fake\ChasterDtoBundle\Objects\Dto\KeyholderLockActionDto;
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
}
