<?php

namespace Fake\ChasterDtoBundle\Tests\Objects\Dto;

use Fake\ChasterDtoBundle\Objects\Dto\SharedLockDto;
use Fake\ChasterDtoFactory\Factory\SharedLockDtoFactory;
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

    public function testCreate()
    {
        $test = SharedLockDtoFactory::createOne();

        $dto = SharedLockDto::create(lockId: $test->getId(), displayRemainingTime: $test->getDisplayRemainingTime(),
            photoId: $test->getPhotoId(), minDuration: $test->getMinDuration(), maxDuration: $test->getMaxDuration(),
            maxLimitDuration: $test->getMaxLimitDuration(), minDate: $test->getMinDate(),
            maxDate: $test->getMaxDate(), maxLimitDate: $test->getMaxLimitDate(), tags: $test->getTags());

        self::assertSame($test->getId(), $dto->getId());
        self::assertSame($test->getDisplayRemainingTime(), $dto->getDisplayRemainingTime());
        self::assertSame($test->getHideTimeLogs(), $dto->getHideTimeLogs());
        self::assertSame($test->getPhotoId(), $dto->getPhotoId());
        self::assertSame($test->getMinDuration(), $dto->getMinDuration());
        self::assertSame($test->getMaxDuration(), $dto->getMaxDuration());
        self::assertSame($test->getMaxLimitDuration(), $dto->getMaxLimitDuration());
        self::assertSame($test->getMinDate(), $dto->getMinDate());
        self::assertSame($test->getMaxDate(), $dto->getMaxDate());
        self::assertSame($test->getMaxLimitDate(), $dto->getMaxLimitDate());
        self::assertSame($test->getLimitLockTime(), $dto->getLimitLockTime());
        self::assertSame($test->getTags(), $dto->getTags());
    }
}
