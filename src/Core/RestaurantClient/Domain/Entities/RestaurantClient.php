<?php

declare(strict_types=1);

namespace CoverManager\Core\RestaurantClient\Domain\Entities;

use CoverManager\Core\Restaurant\Domain\ValueObjects\RestaurantId;
use CoverManager\Core\RestaurantClient\Domain\Enums\RestaurantClientStatusEnum;
use CoverManager\Core\RestaurantClient\Domain\Events\RestaurantClientCreatedEvent;
use CoverManager\Core\RestaurantClient\Domain\Events\RestaurantClientUpdatedEvent;
use CoverManager\Core\RestaurantClient\Domain\Exceptions\SameClientException;
use CoverManager\Core\RestaurantClient\Domain\ValueObjects\AppRestaurantClientId;
use CoverManager\Core\RestaurantClient\Domain\ValueObjects\RestaurantClientId;
use CoverManager\Core\Shared\Domain\ValueObjects\Address;
use CoverManager\Core\Shared\Domain\ValueObjects\ClientIdentification;
use CoverManager\Core\Shared\Domain\ValueObjects\ClientIntegrationInfo;
use CoverManager\Core\Shared\Domain\ValueObjects\ClientPreferences;
use CoverManager\Core\Shared\Domain\ValueObjects\ClientStats;
use CoverManager\Core\Shared\Domain\ValueObjects\MarketingSubscription;
use CoverManager\Shared\Framework\Domain\Entities\BaseEntity;
use CoverManager\Shared\Framework\Helpers\MixedHelper;

final class RestaurantClient extends BaseEntity
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
     * @param  int  $addedAt
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
        public int $addedAt,
        public ?string $language,
        public ?string $companyName,
        public ?Address $address,
        public MarketingSubscription $marketingSubscription,
        public array $integrations,
        public ?string $dob,
        public array $customProperties
    ) {
    }

    /**
     * Create a new RestaurantClient entity
     *
     * @param  RestaurantClientId  $id
     * @param  RestaurantId  $restaurantId
     * @param  AppRestaurantClientId  $appRestaurantClientId
     * @param  MarketingSubscription  $marketingSubscription
     * @param  ClientIdentification|null  $identification
     * @param  ClientPreferences|null  $preferences
     * @param  ClientStats|null  $stats
     * @param  ClientStats|null  $last3MonthsStats
     * @param  int|null  $statsUpdatedAt
     * @param  int|null  $addedAt
     * @param  string|null  $language
     * @param  string|null  $companyName
     * @param  Address|null  $address
     * @param  array<ClientIntegrationInfo>  $integrations
     * @param  string|null  $dob
     * @param  array<string,bool|float|int|string>  $customProperties
     * @return self
     */
    public static function create(
        RestaurantClientId $id,
        RestaurantId $restaurantId,
        AppRestaurantClientId $appRestaurantClientId,
        MarketingSubscription $marketingSubscription,
        ?ClientIdentification $identification = null,
        ?ClientPreferences $preferences = null,
        ?ClientStats $stats = null,
        ?ClientStats $last3MonthsStats = null,
        ?int $statsUpdatedAt = null,
        ?int $addedAt = null,
        ?string $language = null,
        ?string $companyName = null,
        ?Address $address = null,
        array $integrations = [],
        ?string $dob = null,
        array $customProperties = []
    ): self {
        $instance = new self(
            id: $id,
            restaurantId: $restaurantId,
            appRestaurantClientId: $appRestaurantClientId,
            status: RestaurantClientStatusEnum::ACTIVE, // Default status is ACTIVE
            identification: $identification,
            preferences: $preferences,
            stats: $stats,
            last3MonthsStats: $last3MonthsStats,
            statsUpdatedAt: $statsUpdatedAt ?? time(),
            addedAt: $addedAt ?? time(),
            language: $language,
            companyName: $companyName,
            address: $address,
            marketingSubscription: $marketingSubscription,
            integrations: $integrations,
            dob: $dob,
            customProperties: $customProperties
        );
        $instance->recordLast(RestaurantClientCreatedEvent::create($instance));
        return $instance;
    }


    /**
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
     * @return void
     */
    public function update(
        MarketingSubscription $marketingSubscription,
        ?ClientIdentification $identification = null,
        ?ClientPreferences $preferences = null,
        ?ClientStats $stats = null,
        ?ClientStats $last3MonthsStats = null,
        ?int $statsUpdatedAt = null,
        ?string $language = null,
        ?string $companyName = null,
        ?Address $address = null,
        array $integrations = [],
        ?string $dob = null,
        array $customProperties = []
    ): void {
        $address = $this->cleanValueObject($address);
        $identification = $this->cleanValueObject($identification);
        $preferences = $this->cleanValueObject($preferences);
        $stats = $this->cleanValueObject($stats);
        $last3MonthsStats = $this->cleanValueObject($last3MonthsStats);
        $before = clone $this;
        $this->marketingSubscription = $marketingSubscription;
        $this->identification = $identification;
        $this->preferences = $preferences;
        $this->stats = $stats;
        $this->last3MonthsStats = $last3MonthsStats;
        $this->statsUpdatedAt = $statsUpdatedAt;
        $this->language = $language;
        $this->companyName = $companyName;
        $this->address = $address;
        $this->integrations = $integrations;
        $this->dob = $dob;
        $this->customProperties = array_merge($this->customProperties, $customProperties);
        $this->recordLast(RestaurantClientUpdatedEvent::create(origRestaurantClient: $before, modifiedRestaurantClient: $this));
    }

    /**
     * If the data is the same, it will fail
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
     * @return void
     */
    public function updateUnique(
        MarketingSubscription $marketingSubscription,
        ?ClientIdentification $identification = null,
        ?ClientPreferences $preferences = null,
        ?ClientStats $stats = null,
        ?ClientStats $last3MonthsStats = null,
        ?int $statsUpdatedAt = null,
        ?string $language = null,
        ?string $companyName = null,
        ?Address $address = null,
        array $integrations = [],
        ?string $dob = null,
        array $customProperties = []
    ): void {
        $before = clone $this;
        $this->update(
            marketingSubscription: $marketingSubscription,
            identification: $identification,
            preferences: $preferences,
            stats: $stats,
            last3MonthsStats: $last3MonthsStats,
            statsUpdatedAt: $statsUpdatedAt,
            language: $language,
            companyName: $companyName,
            address: $address,
            integrations: $integrations,
            dob: $dob,
            customProperties: $customProperties
        );

        if ($this->sameAs($before)) {
            throw new SameClientException('RestaurantClient data is the same, update failed.');
        }
        $this->recordLast(RestaurantClientUpdatedEvent::create(origRestaurantClient: $before, modifiedRestaurantClient: $this));
    }

    /**
     * Clean the value object by removing null and empty values
     *
     * @template T of mixed
     * @param  T  $object
     * @return T|null
     */
    private function cleanValueObject(mixed $object): mixed
    {
        if ($object === null) {
            return null;
        }
        /** @var array<mixed> $array */
        $array = json_decode(json_encode($object) . '', true);
        $array = array_filter($array, function ($value) {
            return $value !== null && $value !== '';
        });
        if (empty($array)) {
            return null;
        }
        return $object;
    }

    /**
     * Mark the restaurant client as deleted
     *
     * @return void
     */
    public function delete(): void
    {
        $this->status = RestaurantClientStatusEnum::DELETED;
    }

    public function sameAs(RestaurantClient $other, bool $debug = false): bool
    {
        if ($debug) {
            echo "Comparing RestaurantClient: " . ($this->id->getValue() === $other->id->getValue() ? 'true' : 'false') . "\n";
            echo "Restaurant ID: " . ($this->restaurantId->equals($other->restaurantId) ? 'true' : 'false') . "\n";
            echo "App ID (App): " . ($this->appRestaurantClientId->app === $other->appRestaurantClientId->app ? 'true' : 'false') . "\n";
            echo "App ID (ID): " . ($this->appRestaurantClientId->id === $other->appRestaurantClientId->id ? 'true' : 'false') . "\n";
            echo "Status: " . ($this->status === $other->status ? 'true' : 'false') . "\n";
            echo "Identification: " . (MixedHelper::safeJson($this->identification) === MixedHelper::safeJson($other->identification) ? 'true' : 'false') . "\n";
            print_r($this->identification);
            print_r($other->identification);
            echo "Preferences: " . (MixedHelper::getNonEmptyArray($this->preferences) === MixedHelper::getNonEmptyArray($other->preferences) ? 'true' : 'false') . "\n";
            echo "Stats: " . (MixedHelper::safeJson($this->stats) === MixedHelper::safeJson($other->stats) ? 'true' : 'false') . "\n";
            echo "Last 3 Months Stats: " . (MixedHelper::safeJson($this->last3MonthsStats) === MixedHelper::safeJson($other->last3MonthsStats) ? 'true' : 'false') . "\n";
            echo "Stats Updated At: " . ($this->statsUpdatedAt === $other->statsUpdatedAt ? 'true' : 'false') . "\n";
            echo "Added At: " . ($this->addedAt === $other->addedAt ? 'true' : 'false') . "\n";
            echo "Language: " . ($this->language === $other->language ? 'true' : 'false') . "\n";
            echo "Company Name: " . ($this->companyName === $other->companyName ? 'true' : 'false') . "\n";
            echo "Address: " . (MixedHelper::getNonEmptyArray($this->address) === MixedHelper::getNonEmptyArray($other->address) ? 'true' : 'false') . "\n";
            echo "Marketing Subscription: " . (MixedHelper::getNonEmptyArray($this->marketingSubscription) === MixedHelper::getNonEmptyArray($other->marketingSubscription) ? 'true' : 'false') . "\n";


            echo "Integrations: " . (MixedHelper::safeJson($this->integrations) === MixedHelper::safeJson($other->integrations) ? 'true' : 'false') . "\n";
            echo "DOB: " . ($this->dob === $other->dob ? 'true' : 'false') . "\n";
            echo "Custom Properties: " . (MixedHelper::safeJson($this->customProperties) === MixedHelper::safeJson($other->customProperties) ? 'true' : 'false') . "\n";
        }


        return $this->restaurantId->equals($other->restaurantId)
            && $this->appRestaurantClientId->app === $other->appRestaurantClientId->app
            && $this->appRestaurantClientId->id === $other->appRestaurantClientId->id
            && $this->status === $other->status
            && MixedHelper::safeJson($this->identification) === MixedHelper::safeJson($other->identification)
            && MixedHelper::getNonEmptyArray($this->preferences) === MixedHelper::getNonEmptyArray($other->preferences)
            && MixedHelper::safeJson($this->stats) === MixedHelper::safeJson($other->stats)
            && MixedHelper::safeJson($this->last3MonthsStats) === MixedHelper::safeJson($other->last3MonthsStats)
            && $this->statsUpdatedAt === $other->statsUpdatedAt
            && $this->addedAt === $other->addedAt
            && $this->language === $other->language
            && $this->companyName === $other->companyName
            && MixedHelper::getNonEmptyArray($this->address) === MixedHelper::getNonEmptyArray($other->address)
            && MixedHelper::getNonEmptyArray($this->marketingSubscription) === MixedHelper::getNonEmptyArray($other->marketingSubscription)
            && MixedHelper::safeJson($this->integrations) === MixedHelper::safeJson($other->integrations)
            && $this->dob === $other->dob
            && array_diff_assoc($this->customProperties, $other->customProperties) === [];
    }

}
