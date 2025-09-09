<?php

declare(strict_types=1);

namespace CoverManager\Core\RestaurantClient\Application\Commands\Update;

use CoverManager\Core\RestaurantClient\Domain\ValueObjects\RestaurantClientId;
use CoverManager\Core\Shared\Domain\ValueObjects\Address;
use CoverManager\Core\Shared\Domain\ValueObjects\ClientIdentification;
use CoverManager\Core\Shared\Domain\ValueObjects\ClientIntegrationInfo;
use CoverManager\Core\Shared\Domain\ValueObjects\ClientPreferences;
use CoverManager\Core\Shared\Domain\ValueObjects\ClientStats;
use CoverManager\Core\Shared\Domain\ValueObjects\MarketingSubscription;
use CoverManager\Shared\Framework\Application\Commands\CommandInterface;

/**
 * @see UpdateRestaurantClientHandler
 */
final readonly class UpdateRestaurantClientCommand implements CommandInterface
{
    /**
     * @param  RestaurantClientId  $id
     * @param  MarketingSubscription  $marketingSubscription
     * @param  ClientIdentification|null  $identification
     * @param  ClientPreferences|null  $preferences
     * @param  ClientStats|null  $stats
     * @param  ClientStats|null  $last3MonthsStats
     * @param  int|null  $statsUpdatedAt
     * @param  string|null  $language
     * @param  string|null  $companyName
     * @param  Address|null  $address
     * @param  array<ClientIntegrationInfo>  $integrations
     * @param  string|null  $dob
     * @param  array<string,string|int|bool|float>  $customProperties
     */
    public function __construct(
        public RestaurantClientId $id,
        public MarketingSubscription $marketingSubscription,
        public ?ClientIdentification $identification = null,
        public ?ClientPreferences $preferences = null,
        public ?ClientStats $stats = null,
        public ?ClientStats $last3MonthsStats = null,
        public ?int $statsUpdatedAt = null,
        public ?string $language = null,
        public ?string $companyName = null,
        public ?Address $address = null,
        public array $integrations = [],
        public ?string $dob = null,
        public array $customProperties = []
    ) {
    }

}
