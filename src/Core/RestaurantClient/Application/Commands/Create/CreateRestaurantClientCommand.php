<?php

declare(strict_types=1);

namespace CoverManager\Core\RestaurantClient\Application\Commands\Create;

use CoverManager\Core\Restaurant\Domain\ValueObjects\RestaurantId;
use CoverManager\Core\RestaurantClient\Domain\ValueObjects\AppRestaurantClientId;
use CoverManager\Core\RestaurantClient\Domain\ValueObjects\RestaurantClientId;
use CoverManager\Core\Shared\Domain\ValueObjects\Address;
use CoverManager\Core\Shared\Domain\ValueObjects\ClientIdentification;
use CoverManager\Core\Shared\Domain\ValueObjects\ClientIntegrationInfo;
use CoverManager\Core\Shared\Domain\ValueObjects\ClientPreferences;
use CoverManager\Core\Shared\Domain\ValueObjects\ClientStats;
use CoverManager\Core\Shared\Domain\ValueObjects\MarketingSubscription;
use CoverManager\Shared\Framework\Application\Commands\CommandInterface;

/**
 * @see CreateRestaurantClientHandler
 */
final readonly class CreateRestaurantClientCommand implements CommandInterface
{
    /**
     * @param  RestaurantClientId  $id
     * @param  RestaurantId  $restaurantId
     * @param  AppRestaurantClientId  $clientId
     * @param  MarketingSubscription  $marketingSubscription
     * @param  ClientIdentification  $identification
     * @param  ClientPreferences|null  $preferences
     * @param  ClientStats|null  $stats
     * @param  ClientStats|null  $last3MonthsStats
     * @param  int|null  $statsUpdatedAt
     * @param  string|null  $language
     * @param  string|null  $companyName
     * @param  Address|null  $address
     * @param  array<ClientIntegrationInfo>  $integrations
     * @param  string|null  $dob
     * @param  array<string,bool|float|int|string>  $customProperties
     * @param  int|null  $addedAt
     */
    public function __construct(
        public RestaurantClientId $id,
        public RestaurantId $restaurantId,
        public AppRestaurantClientId $clientId,
        public MarketingSubscription $marketingSubscription,
        public ClientIdentification $identification,
        public ?ClientPreferences $preferences = null,
        public ?ClientStats $stats = null,
        public ?ClientStats $last3MonthsStats = null,
        public ?int $statsUpdatedAt = null,
        public ?string $language = null,
        public ?string $companyName = null,
        public ?Address $address = null,
        public array $integrations = [],
        public ?string $dob = null,
        public array $customProperties = [],
        public ?int $addedAt = null
    ) {
    }


}
