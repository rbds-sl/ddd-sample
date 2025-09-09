<?php

declare(strict_types=1);

namespace CoverManager\Core\RestaurantClient\Application\Commands\Create;

use CoverManager\Core\RestaurantClient\Domain\Entities\RestaurantClient;
use CoverManager\Core\RestaurantClient\Domain\Repositories\RestaurantClientRepositoryInterface;
use CoverManager\Shared\Framework\Infrastructure\Bus\CommandBus\CommandHandlerInterface;
use CoverManager\Shared\Framework\Infrastructure\Bus\EventBus\EventBusInterface;

final readonly class CreateRestaurantClientHandler implements CommandHandlerInterface
{
    public function __construct(
        private RestaurantClientRepositoryInterface $repository,
        private EventBusInterface $eventBus
    ) {
    }

    public function __invoke(CreateRestaurantClientCommand $command): void
    {
        $client = RestaurantClient::create(
            id: $command->id,
            restaurantId: $command->restaurantId,
            appRestaurantClientId: $command->clientId,
            marketingSubscription: $command->marketingSubscription,
            identification: $command->identification,
            preferences: $command->preferences,
            stats: $command->stats,
            last3MonthsStats: $command->last3MonthsStats,
            statsUpdatedAt: $command->statsUpdatedAt,
            addedAt: $command->addedAt,
            language: $command->language,
            companyName: $command->companyName,
            address: $command->address,
            integrations: $command->integrations,
            dob: $command->dob,
            customProperties: $command->customProperties
        );
        $this->repository->store($client);
        $this->eventBus->publishEvents($client->pullDomainEvents());
    }

}
