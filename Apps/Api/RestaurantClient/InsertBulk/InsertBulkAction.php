<?php

declare(strict_types=1);

namespace Apps\Api\RestaurantClient\InsertBulk;

use CoverManager\Core\RestaurantClient\Application\Commands\Create\CreateRestaurantClientCommand;
use CoverManager\Core\RestaurantClient\Application\ProcessManagers\BulkInsert\BulkInsertRestaurantClientProcess;
use CoverManager\Shared\Framework\Infrastructure\Bus\CommandBus\CommandBusInterface;

final readonly class InsertBulkAction
{
    public function __construct(private CommandBusInterface $commandBus)
    {

    }

    /**
     * @param  array<CreateRestaurantClientCommand>  $clients
     * @return void
     */
    public function __invoke(
        array $clients
    ): void {
        $this->commandBus->dispatchProcess(new BulkInsertRestaurantClientProcess(
            createRestaurantClientCommands: $clients,
            triggerEvents: false
        ), async: true);

    }

}
