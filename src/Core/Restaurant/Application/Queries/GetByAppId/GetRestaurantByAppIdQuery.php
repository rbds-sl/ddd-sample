<?php

declare(strict_types=1);

namespace CoverManager\Core\Restaurant\Application\Queries\GetByAppId;

use CoverManager\Core\Restaurant\Application\Queries\Shared\RestaurantDto;
use CoverManager\Core\Restaurant\Domain\ValueObjects\AppRestaurantId;
use CoverManager\Shared\Framework\Infrastructure\Bus\QueryBus\QueryInterface;

/**
 * @see GetRestaurantByAppIdHandler
 * @implements QueryInterface<RestaurantDto>
 */
final readonly class GetRestaurantByAppIdQuery implements QueryInterface
{
    public function __construct(
        public AppRestaurantId $id
    ) {
    }
}
