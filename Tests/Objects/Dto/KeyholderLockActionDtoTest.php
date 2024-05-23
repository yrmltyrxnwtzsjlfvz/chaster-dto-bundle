<?php

namespace Fake\ChasterDtoBundle\Tests\Objects\Dto;

use Bytes\DateBundle\Objects\ComparableDateInterval;
use DateInterval;
use Fake\ChasterDtoBundle\Enums\ChasterDtoActions;
use Fake\ChasterDtoBundle\Objects\Dto\KeyholderLockActionDto;
use Generator;
use Symfony\Component\Validator\Exception\ValidationFailedException;

/**
 * @method static KeyholderLockActionDto createBasicDto()
 */
class KeyholderLockActionDtoTest extends AbstractTestLockDto
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
            ->setReason(AbstractTestLockDto::TEST_LOCKID);

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

    public function testGetSetReason()
    {
        $lock = self::createBasicDto()
            ->setAction(ChasterDtoActions::PILLORY);

        $this->assertNull($lock->getReason());

        $lock->setReason(self::TEST_REASON);
        $this->assertEquals(self::TEST_REASON, $lock->getReason());
    }

    public function provideEqualMinMaxLengths(): Generator
    {
        yield ['length' => 300, 'minLength' => 300, 'maxLength' => 300];
    }

    /**
     * @dataProvider provideEqualMinMaxLengths
     */
    public function testRandomizeLengthEqual($length, $minLength, $maxLength): void
    {
        $lock = self::createBasicDto()
            ->setMinLength($minLength)
            ->setMaxLength($maxLength);

        // $this->assertEquals(new \DateInterval('PT5M'), $lock->getMinLength());
        // $this->assertEquals(new \DateInterval('PT5M'), $lock->getMaxLength());

        $lock->randomizeLength();
        $this->assertEquals(new DateInterval('PT5M'), $lock->getLength());
    }

    public function provideMinMaxLengths(): Generator
    {
        yield ['length' => [300, 360], 'minLength' => 300, 'maxLength' => 360];
        yield ['length' => [300, 360], 'minLength' => 360, 'maxLength' => 300];
    }

    /**
     * @dataProvider provideMinMaxLengths
     */
    public function testRandomizeLength($length, $minLength, $maxLength): void
    {
        $lock = self::createBasicDto()
            ->setMinLength($minLength)
            ->setMaxLength($maxLength);

        $lock->randomizeLength();
        $this->assertContains(ComparableDateInterval::normalizeToSeconds($lock->getLength()), $length);
    }
}
