<?php

declare(strict_types=1);

namespace CoverManager\Core\RestaurantClient\Application\Queries\FindRestaurantClient;

use CoverManager\Core\RestaurantClient\Application\Queries\Common\RestaurantClientDto;
use CoverManager\Core\RestaurantClient\Domain\ValueObjects\AppRestaurantClientId;
use CoverManager\Shared\Framework\Infrastructure\Bus\QueryBus\QueryInterface;

/**
 * @see FindRestaurantClientByAppHandler
 * @implements QueryInterface<RestaurantClientDto|null>
 */
final readonly class FindRestaurantClientByAppQuery implements QueryInterface
{
    public function __construct(
        public AppRestaurantClientId $appRestaurantClientId
    ) {
    }
}
