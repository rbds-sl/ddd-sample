<?php

declare(strict_types=1);

namespace CoverManager\Core\Restaurant\Application\Commands\Create;

use CoverManager\Core\Restaurant\Domain\ValueObjects\AppRestaurantId;
use CoverManager\Core\Restaurant\Domain\ValueObjects\RestaurantId;
use CoverManager\Shared\Framework\Application\Commands\CommandInterface;

/**
 * @see CreateRestaurantHandler
 */
final readonly class CreateRestaurantCommand implements CommandInterface
{
    /**
     * @param RestaurantId $id
     * @param AppRestaurantId $appRestaurantId
     * @param string $name
     */
    public function __construct(
        public RestaurantId $id,
        public AppRestaurantId $appRestaurantId,
        public string $name
    ) {
    }
}
