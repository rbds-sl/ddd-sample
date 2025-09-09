<?php

declare(strict_types=1);

namespace CoverManager\Core\Restaurant\Application\Commands\Update;

use CoverManager\Core\Restaurant\Domain\ValueObjects\RestaurantId;
use CoverManager\Shared\Framework\Application\Commands\CommandInterface;

/**
 * @see UpdateRestaurantHandler
 */
final readonly class UpdateRestaurantCommand implements CommandInterface
{
    /**
     * @param RestaurantId $id
     * @param string $name
     */
    public function __construct(
        public RestaurantId $id,
        public string $name
    ) {
    }
}
