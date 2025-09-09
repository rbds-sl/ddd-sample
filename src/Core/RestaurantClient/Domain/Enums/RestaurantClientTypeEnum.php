<?php

declare(strict_types=1);

namespace CoverManager\Core\RestaurantClient\Domain\Enums;

enum RestaurantClientTypeEnum: string
{
    case WALK_IN = 'WALK_IN';
    case DELETED = 'DELETED';
    case ANONYMOUS = 'ANONYMOUS';
    case PRE_RESERVE = 'PRE_RESERVE';

    case STANDARD = 'STANDARD';

}
