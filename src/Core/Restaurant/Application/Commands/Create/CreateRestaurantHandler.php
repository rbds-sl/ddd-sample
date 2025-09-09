<?php

declare(strict_types=1);

namespace CoverManager\Core\Restaurant\Application\Commands\Create;

use CoverManager\Core\Restaurant\Domain\Entities\Restaurant;
use CoverManager\Core\Restaurant\Domain\Repositories\RestaurantRepositoryInterface;
use CoverManager\Shared\Framework\Infrastructure\Bus\CommandBus\CommandHandlerInterface;
use CoverManager\Shared\Framework\Infrastructure\Bus\EventBus\EventBusInterface;

final readonly class CreateRestaurantHandler implements CommandHandlerInterface
{
    public function __construct(
        private RestaurantRepositoryInterface $repository,
        private EventBusInterface $eventBus
    ) {
    }

    public function __invoke(CreateRestaurantCommand $command): void
    {
        $restaurant = Restaurant::create(
            restaurantId: $command->id,
            appRestaurantId: $command->appRestaurantId,
            name: $command->name
        );

        $this->repository->store($restaurant);
        $this->eventBus->publishEvents($restaurant->releaseEvents());
    }
}
