<?php

require dirname(__DIR__).'/vendor/autoload.php';

Zenstruck\Foundry\Test\UnitTestConfig::configure(
    instantiator: Zenstruck\Foundry\Object\Instantiator::withoutConstructor()
        ->allowExtra()
        ->alwaysForce(),
    faker: Faker\Factory::create('en_US')
);
