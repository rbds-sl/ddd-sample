<?php

declare(strict_types=1);

namespace CoverManager\Core\RestaurantClient\Application\Queries\Common;

use CoverManager\Core\RestaurantClient\Domain\Entities\RestaurantClient;

final readonly class RestaurantClientDtoMapper
{
    public static function mapToDto(RestaurantClient $entity): RestaurantClientDto
    {
        return new RestaurantClientDto(
            id: $entity->id,
            restaurantId: $entity->restaurantId,
            appRestaurantClientId: $entity->appRestaurantClientId,
            status: $entity->status,
            identification: $entity->identification,
            preferences: $entity->preferences,
            stats: $entity->stats,
            last3MonthsStats: $entity->last3MonthsStats,
            statsUpdatedAt: $entity->statsUpdatedAt,
            createdAt: $entity->addedAt,
            language: $entity->language,
            companyName: $entity->companyName,
            address: $entity->address,
            marketingSubscription: $entity->marketingSubscription,
            integrations: $entity->integrations,
            dob: $entity->dob,
            customProperties: $entity->customProperties
        );
    }
}
