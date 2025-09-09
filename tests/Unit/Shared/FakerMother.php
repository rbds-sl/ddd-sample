<?php

declare(strict_types=1);

namespace Tests\Unit\Shared;

use Faker\Factory as FakerFactory;
use Faker\Generator as Faker;

final class FakerMother
{
    private static ?Faker $faker = null;

    public static function getFaker(): Faker
    {
        if (self::$faker === null) {
            self::$faker = FakerFactory::create();
        }

        return self::$faker;
    }

    public static function quantity(int $min = 1, int $max = 2000): int
    {
        return self::getFaker()->numberBetween($min, $max);
    }

    public static function name(): string
    {
        return self::getFaker()->name;
    }

    public static function firstName(): string
    {
        return self::getFaker()->firstName();
    }

    public static function lastName(): string
    {
        return self::getFaker()->lastName();
    }

    public static function restaurantName(): string
    {
        return self::getFaker()->company();
    }

    public static function restaurantShortName(): string
    {
        return self::getFaker()->companySuffix();
    }

    public static function slug(): string
    {
        return self::getFaker()->slug();
    }

    public static function uuid(): string
    {
        return self::getFaker()->uuid;
    }

    public static function randomBoolean(): bool
    {
        return self::getFaker()->boolean;
    }

    /**
     * @param class-string<BackedEnum> $class
     */
    public static function randomItem(string $class): mixed
    {
        return self::getFaker()->randomElement($class::cases());
    }

    public static function date(): string
    {
        return self::getFaker()->date();
    }

    public static function hour(): string
    {
        return self::getFaker()->time();
    }

    public static function colour(): string
    {
        return self::getFaker()->hexColor;
    }

    public static function dateTime(): string
    {
        return self::getFaker()->dateTime()->format('Y-m-d H:i:s');
    }

    public static function randomArrayInts(int $min = 1, int $max = 2000): array
    {
        $quantity = self::quantity($min, $max);
        $array = [];

        for ($i = 0; $i < $quantity; $i++) {
            $array[] = self::quantity();
        }

        return $array;
    }

    public static function randomArrayNames(int $min = 1, int $max = 2000): array
    {
        $quantity = self::quantity($min, $max);
        $array = [];

        for ($i = 0; $i < $quantity; $i++) {
            $array[] = self::name();
        }

        return $array;
    }

    public static function randomComment(int $min = 6, int $max = 2000): string
    {
        $textLength = rand($min, max($min, $max));

        return self::getFaker()->text($textLength);
    }

    public static function time(): string
    {
        return self::getFaker()->time();
    }

    public static function phone(): string
    {
        return self::getFaker()->phoneNumber();
    }

    public static function email(): string
    {
        return self::getFaker()->email();
    }

    public static function postalCode(): string
    {
        return self::getFaker()->postcode();
    }

    public static function subject(): string
    {
        return self::getFaker()->sentence();
    }

    public static function comments(): string
    {
        return self::getFaker()->text();
    }

    public static function address(): string
    {
        return self::getFaker()->address();
    }

    public static function city(): string
    {
        return self::getFaker()->city();
    }

    public static function country(): string
    {
        return self::getFaker()->country();
    }

    public static function province(): string
    {
        return self::getFaker()->state();
    }

    public static function userName(): string
    {
        return self::getFaker()->userName();
    }

    public static function intCallCode(): string
    {
        return '+' . self::getFaker()->numberBetween(1, 9999);
    }

    public static function float(): float
    {
        return self::getFaker()->randomFloat();
    }

    public static function url(): string
    {
        return self::getFaker()->url();
    }

    public static function token(): string
    {
        return self::getFaker()->bothify('??????');
    }

    /**
     * Generates an array of random objects
     * by calling the `random` method of the given class.
     */
    public static function arrayRandom(string $className, int $min = 1, int $max = 5): array
    {
        $count = self::quantity($min, $max);
        $result = [];
        for ($i = 0; $i < $count; $i++) {
            $result[] = $className::random();
        }
        return $result;
    }

    public static function randomString(int $length): string
    {
        return self::getFaker()->regexify(str_repeat('[A-Za-z0-9]', $length));
    }

    public static function integer(): int
    {
        return self::getFaker()->numberBetween();
    }
}
