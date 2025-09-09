<?php

declare(strict_types=1);

namespace CoverManager\Shared\Framework\Domain\Enums;

trait TryFromOrNullTrait
{
    public static function tryFromOrNull(?string $value): ?static
    {
        if ($value === null) {
            return null;
        }

        return static::tryFrom($value);
    }
}
