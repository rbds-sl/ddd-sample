<?php

declare(strict_types=1);

namespace CoverManager\Core\Restaurant\Application\Commands\Deactivate;

use CoverManager\Core\Restaurant\Domain\ValueObjects\RestaurantId;
use CoverManager\Shared\Framework\Application\Commands\CommandInterface;

/**
 * @see DeactivateRestaurantHandler
 */
final readonly class DeactivateRestaurantCommand implements CommandInterface
{
    /**
     * @param RestaurantId $id
     */
    public function __construct(
        public RestaurantId $id
    ) {
    }
}
