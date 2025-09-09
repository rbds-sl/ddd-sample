<?php

declare(strict_types=1);

namespace Apps\Api\RestaurantClient\Create;

use CoverManager\Core\RestaurantClient\Application\Commands\Create\CreateRestaurantClientCommand;
use CoverManager\Shared\Framework\Infrastructure\Bus\CommandBus\CommandBusInterface;

final readonly class CreateClientAction
{
    public function __construct(private CommandBusInterface $commandBus)
    {
    }

    public function __invoke(CreateRestaurantClientCommand $command): void
    {
        $this->commandBus->dispatch($command);
    }
}
