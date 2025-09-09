<?php

declare(strict_types=1);

namespace CoverManager\Core\RestaurantClient\Application\Queries\Common;

use CoverManager\Core\Restaurant\Domain\ValueObjects\RestaurantId;
use CoverManager\Core\RestaurantClient\Domain\Enums\RestaurantClientStatusEnum;
use CoverManager\Core\RestaurantClient\Domain\ValueObjects\AppRestaurantClientId;
use CoverManager\Core\RestaurantClient\Domain\ValueObjects\RestaurantClientId;
use CoverManager\Core\Shared\Domain\ValueObjects\Address;
use CoverManager\Core\Shared\Domain\ValueObjects\ClientIdentification;
use CoverManager\Core\Shared\Domain\ValueObjects\ClientIntegrationInfo;
use CoverManager\Core\Shared\Domain\ValueObjects\ClientPreferences;
use CoverManager\Core\Shared\Domain\ValueObjects\ClientStats;
use CoverManager\Core\Shared\Domain\ValueObjects\MarketingSubscription;

final class RestaurantClientDto
{
    /**
     * @param  RestaurantClientId  $id
     * @param  RestaurantId  $restaurantId
     * @param  AppRestaurantClientId  $appRestaurantClientId
     * @param  RestaurantClientStatusEnum  $status
     * @param  ClientIdentification|null  $identification
     * @param  ClientPreferences|null  $preferences
     * @param  ClientStats|null  $stats
     * @param  ClientStats|null  $last3MonthsStats
     * @param  int|null  $statsUpdatedAt
     * @param  int  $createdAt
     * @param  string|null  $language
     * @param  string|null  $companyName
     * @param  Address|null  $address
     * @param  MarketingSubscription  $marketingSubscription
     * @param  array<ClientIntegrationInfo>  $integrations
     * @param  string|null  $dob
     * @param  array<string,bool|float|int|string>  $customProperties
     */
    public function __construct(
        public readonly RestaurantClientId $id,
        public readonly RestaurantId $restaurantId,
        public readonly AppRestaurantClientId $appRestaurantClientId,
        public RestaurantClientStatusEnum $status,
        public ?ClientIdentification $identification,
        public ?ClientPreferences $preferences,
        public ?ClientStats $stats,
        public ?ClientStats $last3MonthsStats,
        public ?int $statsUpdatedAt,
        public int $createdAt,
        public ?string $language,
        public ?string $companyName,
        public ?Address $address,
        public MarketingSubscription $marketingSubscription,
        public array $integrations,
        public ?string $dob,
        public array $customProperties
    ) {
    }

}
