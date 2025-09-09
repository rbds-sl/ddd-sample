<?php

declare(strict_types=1);

namespace CoverManager\Core\RestaurantClient\Application\Commands\Update;

use CoverManager\Core\RestaurantClient\Domain\Exceptions\SameClientException;
use CoverManager\Core\RestaurantClient\Domain\Repositories\RestaurantClientRepositoryInterface;
use CoverManager\Shared\Framework\Infrastructure\Bus\CommandBus\CommandHandlerInterface;
use CoverManager\Shared\Framework\Infrastructure\Bus\EventBus\EventBusInterface;

final readonly class UpdateRestaurantClientHandler implements CommandHandlerInterface
{
    public function __construct(
        private RestaurantClientRepositoryInterface $repository,
        private EventBusInterface $eventBus
    ) {
    }

    public function __invoke(UpdateRestaurantClientCommand $command): void
    {
        $client = $this->repository->getById($command->id);

        try {
            $client->updateUnique(
                marketingSubscription: $command->marketingSubscription,
                identification: $command->identification,
                preferences: $command->preferences,
                stats: $command->stats,
                last3MonthsStats: $command->last3MonthsStats,
                statsUpdatedAt: $command->statsUpdatedAt,
                language: $command->language,
                companyName: $command->companyName,
                address: $command->address,
                integrations: $command->integrations,
                dob: $command->dob,
                customProperties: $command->customProperties
            );
        } catch (SameClientException) {
            // LoggerHelper::logInfo('Skipping client update due to same data');
            return;
        }

        $this->repository->store($client);
        $this->eventBus->publishEvents($client->pullDomainEvents());
    }
}
