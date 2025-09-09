<?php

declare(strict_types=1);

namespace CoverManager\Core\Restaurant\Application\Queries\GetById;

use CoverManager\Core\Restaurant\Application\Queries\Shared\RestaurantDto;
use CoverManager\Core\Restaurant\Domain\ValueObjects\RestaurantId;
use CoverManager\Shared\Framework\Infrastructure\Bus\QueryBus\QueryInterface;

/**
 * @see GetRestaurantByIdHandler
 * @implements QueryInterface<RestaurantDto>
 */
final readonly class GetRestaurantByIdQuery implements QueryInterface
{
    public function __construct(
        public RestaurantId $id
    ) {
    }
}
