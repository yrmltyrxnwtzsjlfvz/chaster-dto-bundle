<?php

namespace Fake\ChasterDtoBundle\Tests\Factory;

use Fake\ChasterDtoBundle\Objects\Dto\SharedLockDto;
use Zenstruck\Foundry\ObjectFactory;

/**
 * @extends ObjectFactory<SharedLockDto>
 *
 * @method        SharedLockDto   create(array|callable $attributes = [])
 * @method static SharedLockDto   createOne(array $attributes = [])
 * @method static SharedLockDto[] createMany(int $number, array|callable $attributes = [])
 * @method static SharedLockDto[] createSequence(iterable|callable $sequence)
 */
final class SharedLockDtoFactory extends ObjectFactory
{
    public static function class(): string
    {
        return SharedLockDto::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     */
    protected function defaults(): array|callable
    {
        $showTimer = self::faker()->boolean();
        $duration = self::faker()->boolean();
        $limitLockTime = self::faker()->boolean();

        $minDate = null;
        $maxDate = null;
        $maxLimitDate = null;
        $minDuration = 0;
        $maxDuration = 0;
        $maxLimitDuration = null;

        if ($duration) {
            $minDuration = self::faker()->numberBetween(60, 3600);
            $maxDuration = self::faker()->numberBetween($minDuration, $minDuration * 2);
            $maxLimitDuration = $limitLockTime ? self::faker()->numberBetween($maxDuration, $maxDuration * 2) : null;
        } else {
            $minDate = self::faker()->dateTimeBetween('-1 years', '+1 years');
            $maxDate = self::faker()->dateTimeBetween($minDate->format(DATE_RFC3339), '+1 years');
            $maxLimitDate = $limitLockTime ? self::faker()->dateTimeBetween($maxDate->format(DATE_RFC3339), '+1 years') : null;
        }

        $unsplash = UnsplashPhotoFactory::new();

        return [
            'id' => self::faker()->md5(),
            'calculatedMaxLimitDuration' => self::faker()->numberBetween(), // TODO add value manually
            'description' => self::faker()->paragraph(),
            'displayRemainingTime' => $showTimer,
            'extensions' => null, // TODO add value manually
            'hideTimeLogs' => !$showTimer,
            'lastSavedAt' => self::faker()->dateTime(),

            'durationMode' => $duration ? 'duration' : 'date',

            'minDate' => $minDate,
            'maxDate' => $maxDate,
            'maxLimitDate' => $maxLimitDate,

            'minDuration' => $minDuration,
            'maxDuration' => $maxDuration,
            'maxLimitDuration' => $maxLimitDuration,

            'limitLockTime' => $limitLockTime,

            'maxLockedUsers' => self::faker()->optional()->numberBetween(1, 999),
            'name' => self::faker()->sentence(),
            'publicLock' => self::faker()->boolean(),
            'requireContact' => self::faker()->boolean(),
            'requirePassword' => self::faker()->boolean(),
            'unsplashPhoto' => $unsplash,

            'photoId' => $unsplash->create()->getId(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(SharedLockDto $SharedLockDto): void {})
        ;
    }
}
