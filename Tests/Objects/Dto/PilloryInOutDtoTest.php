<?php

namespace Fake\ChasterDtoBundle\Tests\Objects\Dto;

use Fake\ChasterDtoBundle\Objects\Dto\PilloryInOutDto;
use Fake\ChasterFactory\Factory\ActionLog\PilloryInActionLogFactory;
use Fake\ChasterFactory\Factory\ActionLog\PilloryOutActionLogFactory;
use PHPUnit\Framework\TestCase;
use Zenstruck\Foundry\Test\Factories;

class PilloryInOutDtoTest extends TestCase
{
    use Factories;

    public function testCreate()
    {
        $actionLog = PilloryInActionLogFactory::createOne();
        $dto = PilloryInOutDto::create($actionLog);
        self::assertInstanceOf(PilloryInOutDto::class, $dto);
        self::assertNull($dto->getTimeAdded());

        $actionLog = PilloryOutActionLogFactory::createOne();
        $dto = PilloryInOutDto::create($actionLog);
        self::assertInstanceOf(PilloryInOutDto::class, $dto);
        self::assertNull($dto->getReason());
        self::assertNull($dto->getDuration());
    }
}
