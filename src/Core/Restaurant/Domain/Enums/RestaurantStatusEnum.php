<?php

declare(strict_types=1);

namespace CoverManager\Core\Restaurant\Domain\Enums;

use InvalidArgumentException;

enum RestaurantStatusEnum: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case DELETED = 'deleted';

    public static function getDefaultValue(): self
    {
        return self::INACTIVE;
    }

    public static function fromCover(string $status): self
    {
        return match ($status) {
            'license_active' => self::ACTIVE,
            'license_deactivation', 'license_temporary_deactivation_free', 'license_temporary_deactivation_maintenance', 'temporary_deactivation_license_free' => self::INACTIVE,
            default => throw new InvalidArgumentException("Invalid restaurant status: {$status}"),
        };
    }
}
