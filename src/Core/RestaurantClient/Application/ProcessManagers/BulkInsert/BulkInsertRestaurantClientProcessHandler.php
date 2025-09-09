<?php

declare(strict_types=1);

namespace CoverManager\Core\RestaurantClient\Application\ProcessManagers\BulkInsert;

use CoverManager\Core\RestaurantClient\Domain\Entities\RestaurantClient;
use CoverManager\Core\RestaurantClient\Domain\Repositories\RestaurantClientRepositoryInterface;
use CoverManager\Shared\Framework\Infrastructure\Bus\CommandBus\CommandHandlerInterface;
use CoverManager\Shared\Framework\Infrastructure\Bus\EventBus\EventBusInterface;

final readonly class BulkInsertRestaurantClientProcessHandler implements CommandHandlerInterface
{
    public function __construct(
        private RestaurantClientRepositoryInterface $repository,
        private EventBusInterface $eventBus
    ) {
    }

    public function __invoke(BulkInsertRestaurantClientProcess $command): void
    {
        $clients = [];
        foreach ($command->createRestaurantClientCommands as $createRestaurantClientCommand) {
            $client = RestaurantClient::create(
                id: $createRestaurantClientCommand->id,
                restaurantId: $createRestaurantClientCommand->restaurantId,
                appRestaurantClientId: $createRestaurantClientCommand->clientId,
                marketingSubscription: $createRestaurantClientCommand->marketingSubscription,
                identification: $createRestaurantClientCommand->identification,
                preferences: $createRestaurantClientCommand->preferences,
                stats: $createRestaurantClientCommand->stats,
                last3MonthsStats: $createRestaurantClientCommand->last3MonthsStats,
                statsUpdatedAt: $createRestaurantClientCommand->statsUpdatedAt,
                language: $createRestaurantClientCommand->language,
                companyName: $createRestaurantClientCommand->companyName,
                address: $createRestaurantClientCommand->address,
                integrations: $createRestaurantClientCommand->integrations,
                dob: $createRestaurantClientCommand->dob,
                customProperties: $createRestaurantClientCommand->customProperties
            );
            $clients[] = $client;
        }

        $this->repository->insertBulkClients($clients);
        if ($command->triggerEvents) {
            foreach ($clients as $client) {
                $this->eventBus->publishEvents($client->pullDomainEvents());
            }
        }
    }

}
