<?php

declare(strict_types=1);

namespace CoverManager\Core\RestaurantClient\Application\ProcessManagers\BulkInsert;

use CoverManager\Core\RestaurantClient\Application\Commands\Create\CreateRestaurantClientCommand;
use CoverManager\Shared\Framework\Application\Commands\CommandInterface;

final readonly class BulkInsertRestaurantClientProcess implements CommandInterface
{
    /**
     * @param  array<CreateRestaurantClientCommand>  $createRestaurantClientCommands
     * @param  bool  $triggerEvents
     */
    public function __construct(
        public array $createRestaurantClientCommands,
        public bool $triggerEvents = false,
    ) {
    }

}
