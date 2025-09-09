<?php

declare(strict_types=1);

namespace CoverManager\Core\Restaurant\Application\Queries\Shared;

use CoverManager\Core\Restaurant\Domain\Enums\RestaurantStatusEnum;
use CoverManager\Core\Restaurant\Domain\ValueObjects\AppRestaurantId;
use CoverManager\Core\Restaurant\Domain\ValueObjects\RestaurantId;

final class RestaurantDto
{
    public function __construct(
        public readonly RestaurantId $id,
        public readonly AppRestaurantId $appRestaurantId,
        public string $name,
        public RestaurantStatusEnum $status,
    ) {
    }

}
