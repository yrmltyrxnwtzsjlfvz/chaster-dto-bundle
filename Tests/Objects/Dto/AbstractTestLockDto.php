<?php

namespace Fake\ChasterDtoBundle\Tests\Objects\Dto;

use Bytes\Tests\Common\TestFullValidatorTrait;
use Fake\ChasterDtoBundle\Enums\ChasterDtoActions;
use Fake\ChasterDtoBundle\Objects\Dto\AbstractLockDto;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Exception\ValidationFailedException;

abstract class AbstractTestLockDto extends TestCase
{
    use TestFullValidatorTrait;

    public const TEST_LOCKID = 'abc123';

    public function testWithoutLockId(): void
    {
        $lock = self::createTestClass();

        $this->expectException(ValidationFailedException::class);

        $this->validate($lock);
    }

    public static function createTestClass(): AbstractLockDto
    {
        $class = static::getTestClassName();

        return new $class();
    }

    /**
     * @return class-string<AbstractLockDto>
     */
    abstract public static function getTestClassName(): string;

    abstract public function testGetAction(): void;

    public function testSetAction(): void
    {
        $lock = self::createBasicDto()
            ->setAction(ChasterDtoActions::CREATE_LOCK);
        $this->assertEquals(ChasterDtoActions::CREATE_LOCK, $lock->getAction());
    }

    public static function createBasicDto(): AbstractLockDto
    {
        $lock = self::createTestClass();

        return $lock->setLockId(self::TEST_LOCKID);
    }
}
