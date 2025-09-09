<?php

declare(strict_types=1);

namespace CoverManager\Core\RestaurantClient\Domain\Enums;

enum RestaurantClientStatusEnum: string
{
    case ACTIVE = 'active';
    case BLOCKED = 'blocked';
    case DELETED = 'deleted';

}
