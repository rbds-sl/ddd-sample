<?php

declare(strict_types=1);

namespace CoverManager\Core\Restaurant\Application\Commands\Update;

use CoverManager\Core\Restaurant\Domain\Repositories\RestaurantRepositoryInterface;
use CoverManager\Shared\Framework\Infrastructure\Bus\CommandBus\CommandHandlerInterface;
use CoverManager\Shared\Framework\Infrastructure\Bus\EventBus\EventBusInterface;

final readonly class UpdateRestaurantHandler implements CommandHandlerInterface
{
    public function __construct(
        private RestaurantRepositoryInterface $repository,
        private EventBusInterface $eventBus
    ) {
    }

    public function __invoke(UpdateRestaurantCommand $command): void
    {
        $restaurant = $this->repository->getById($command->id);

        $restaurant->update(
            name: $command->name,
        );

        $this->repository->store($restaurant);
        $this->eventBus->publishEvents($restaurant->releaseEvents());
    }
}
