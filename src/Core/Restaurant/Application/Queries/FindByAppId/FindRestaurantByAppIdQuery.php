<?php

declare(strict_types=1);

namespace CoverManager\Core\Restaurant\Application\Queries\FindByAppId;

use CoverManager\Core\Restaurant\Application\Queries\Shared\RestaurantDto;
use CoverManager\Core\Restaurant\Domain\ValueObjects\AppRestaurantId;
use CoverManager\Shared\Framework\Infrastructure\Bus\QueryBus\QueryInterface;

/**
 * @see FindRestaurantByAppIdHandler
 * @implements QueryInterface<RestaurantDto|null>
 */
final readonly class FindRestaurantByAppIdQuery implements QueryInterface
{
    public function __construct(
        public AppRestaurantId $id
    ) {
    }
}
