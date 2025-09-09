<?php

declare(strict_types=1);

namespace CoverManager\Shared\Framework\Helpers;

use function array_key_exists;

use Illuminate\Support\Facades\Cache;

final class CacheHelper
{
    /** @var array<string,mixed> */
    private static array $cache = [];

    public static function onceByKey(string $key, callable $callback, int $ttl = 0): mixed
    {
        if ($ttl === 0) {
            if (array_key_exists($key, self::$cache)) {
                return self::$cache[$key];
            }

            $value = $callback();
            self::$cache[$key] = $value;

            return $value;
        }

        return Cache::remember($key, $ttl, static function () use ($callback) {
            return $callback();
        });
    }

    public static function reset(): void
    {
        self::$cache = [];
    }

}
