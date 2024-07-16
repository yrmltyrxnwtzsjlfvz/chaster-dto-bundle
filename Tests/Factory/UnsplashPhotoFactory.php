<?php

namespace Fake\ChasterDtoBundle\Tests\Factory;

use Fake\ChasterObjects\Objects\Lock\UnsplashPhoto;
use Zenstruck\Foundry\ObjectFactory;

/**
 * @extends ObjectFactory<UnsplashPhoto>
 *
 * @method        UnsplashPhoto   create(array|callable $attributes = [])
 * @method static UnsplashPhoto   createOne(array $attributes = [])
 * @method static UnsplashPhoto[] createMany(int $number, array|callable $attributes = [])
 * @method static UnsplashPhoto[] createSequence(iterable|callable $sequence)
 */
final class UnsplashPhotoFactory extends ObjectFactory
{
    public static function class(): string
    {
        return UnsplashPhoto::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     */
    protected function defaults(): array|callable
    {
        return [
            'id' => self::faker()->md5(),
            'name' => self::faker()->name(),
            'url' => self::faker()->url(),
            'username' => self::faker()->userName(),
        ];
    }
}
