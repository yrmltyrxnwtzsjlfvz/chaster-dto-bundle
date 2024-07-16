<?php

namespace Fake\ChasterDtoBundle\Tests\Objects\Dto;

use Fake\ChasterDtoBundle\Objects\Dto\SharedLockDto;
use Fake\ChasterDtoBundle\Tests\Factory\SharedLockDtoFactory;
use Faker\Factory;
use PHPUnit\Framework\TestCase;
use Zenstruck\Foundry\Test\Factories;

class SharedLockDtoTest extends TestCase
{
    use Factories;

    public function testHasDurations()
    {
        $faker = Factory::create();
        $dto = SharedLockDtoFactory::createOne([
            'minDate' => null,
            'maxDate' => null,
            'maxLimitDate' => null,
            'minDuration' => $faker->numberBetween(1, 60),
            'maxDuration' => $faker->numberBetween(1, 60),
            'maxLimitDuration' => $faker->optional()->numberBetween(1, 60),
        ]);

        self::assertTrue($dto->hasDurations());
        self::assertFalse($dto->hasDates());
    }

    public function testGetPhotoId()
    {
        $dto = new SharedLockDto();
        self::assertNull($dto->getPhotoId());

        $new = SharedLockDtoFactory::createOne();

        $dto->setPhotoId($new->getPhotoId());
        self::assertSame($new->getPhotoId(), $dto->getPhotoId());
    }

    public function testHasDates()
    {
        $faker = Factory::create();
        $dto = SharedLockDtoFactory::createOne([
            'minDate' => $faker->dateTime(),
            'maxDate' => $faker->dateTime(),
            'maxLimitDate' => $faker->optional()->dateTime(),
            'minDuration' => null,
            'maxDuration' => null,
            'maxLimitDuration' => null,
        ]);

        self::assertTrue($dto->hasDates());
        self::assertFalse($dto->hasDurations());
    }
}
