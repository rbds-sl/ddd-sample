<?php

declare(strict_types=1);

namespace CoverManager\Core\RestaurantClient\Application\Commands\Delete;

use CoverManager\Core\RestaurantClient\Domain\Repositories\RestaurantClientRepositoryInterface;
use CoverManager\Shared\Framework\Infrastructure\Bus\CommandBus\CommandHandlerInterface;
use CoverManager\Shared\Framework\Infrastructure\Bus\EventBus\EventBusInterface;

final readonly class DeleteRestaurantClientHandler implements CommandHandlerInterface
{
    public function __construct(
        private RestaurantClientRepositoryInterface $repository,
        private EventBusInterface $eventBus
    ) {
    }

    public function __invoke(DeleteRestaurantClientCommand $command): void
    {
        $client = $this->repository->getById($command->id);

        $client->delete();

        $this->repository->store($client);
        $this->eventBus->publishEvents($client->pullDomainEvents());
    }
}
