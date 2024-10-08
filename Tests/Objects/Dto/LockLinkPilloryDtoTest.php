<?php

namespace Fake\ChasterDtoBundle\Tests\Objects\Dto;

use Fake\ChasterDtoBundle\Objects\Dto\LockLinkPilloryDto;
use Fake\ChasterFactory\Factory\LockFactory;
use Fake\ChasterFactory\Factory\PilloryStatusFactory;
use Fake\ChasterFactory\Factory\SharedLinkLinkInfoFactory;
use PHPUnit\Framework\TestCase;
use Zenstruck\Foundry\Test\Factories;

class LockLinkPilloryDtoTest extends TestCase
{
    use Factories;

    public function testGetSetLock()
    {
        $lock = LockFactory::createOne();

        $dto = new LockLinkPilloryDto();
        self::assertNull($dto->getLock());
        self::assertInstanceOf(LockLinkPilloryDto::class, $dto->setLock($lock));
        self::assertEquals($lock, $dto->getLock());
    }

    public function testGetSetPillories()
    {
        $pillories = PilloryStatusFactory::createMany(3);

        $dto = new LockLinkPilloryDto();
        self::assertEmpty($dto->getPillories());
        self::assertInstanceOf(LockLinkPilloryDto::class, $dto->setPillories($pillories));
        self::assertEquals($pillories, $dto->getPillories());
    }

    public function testGetSetLink()
    {
        $linkInfo = SharedLinkLinkInfoFactory::createOne();

        $dto = new LockLinkPilloryDto();
        self::assertNull($dto->getLink());
        self::assertInstanceOf(LockLinkPilloryDto::class, $dto->setLink($linkInfo));
        self::assertEquals($linkInfo, $dto->getLink());
    }
}
