<?php

namespace Fake\ChasterDtoBundle\Tests\Objects\Dto;

use Bytes\DateBundle\Objects\ComparableDateInterval;
use DateInterval;
use Generator;

abstract class AbstractTestLockActionDto extends AbstractTestLockDto
{
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
