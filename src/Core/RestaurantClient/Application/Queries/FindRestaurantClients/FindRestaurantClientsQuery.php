<?php

declare(strict_types=1);

namespace CoverManager\Core\RestaurantClient\Application\Queries\FindRestaurantClients;

use CoverManager\Core\Restaurant\Domain\ValueObjects\RestaurantId;
use CoverManager\Core\RestaurantClient\Application\Queries\Common\RestaurantClientDto;
use CoverManager\Shared\Framework\Infrastructure\Bus\QueryBus\QueryInterface;

/**
 * @see FindRestaurantClientsHandler
 * @implements QueryInterface<array<RestaurantClientDto>>
 */
final readonly class FindRestaurantClientsQuery implements QueryInterface
{
    public function __construct(
        public RestaurantId $restaurantId,
        public ?int $limit = null,
        public ?int $offset = null
    ) {
    }

}
