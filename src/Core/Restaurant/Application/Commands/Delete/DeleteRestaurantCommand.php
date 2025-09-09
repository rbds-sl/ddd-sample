<?php

declare(strict_types=1);

namespace CoverManager\Core\Restaurant\Application\Commands\Delete;

use CoverManager\Core\Restaurant\Domain\ValueObjects\RestaurantId;
use CoverManager\Shared\Framework\Application\Commands\CommandInterface;

/**
 * @see DeleteRestaurantHandler
 */
final readonly class DeleteRestaurantCommand implements CommandInterface
{
    /**
     * @param RestaurantId $id
     */
    public function __construct(
        public RestaurantId $id
    ) {
    }
}
