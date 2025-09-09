<?php

declare(strict_types=1);

namespace CoverManager\Core\RestaurantClient\Application\Commands\Delete;

use CoverManager\Core\RestaurantClient\Domain\ValueObjects\RestaurantClientId;
use CoverManager\Shared\Framework\Application\Commands\CommandInterface;

/**
 * @see DeleteRestaurantClientHandler
 */
final readonly class DeleteRestaurantClientCommand implements CommandInterface
{
    /**
     * @param RestaurantClientId $id
     */
    public function __construct(
        public RestaurantClientId $id
    ) {
    }
}
