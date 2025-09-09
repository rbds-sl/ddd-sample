<?php

declare(strict_types=1);

namespace CoverManager\Core\RestaurantClient\Infrastructure\Persistence;

use CoverManager\App\Domain\Enums\AppEnum;
use CoverManager\Core\Restaurant\Domain\ValueObjects\RestaurantId;
use CoverManager\Core\RestaurantClient\Domain\Entities\RestaurantClient;
use CoverManager\Core\RestaurantClient\Domain\Enums\RestaurantClientStatusEnum;
use CoverManager\Core\RestaurantClient\Domain\ValueObjects\AppRestaurantClientId;
use CoverManager\Core\RestaurantClient\Domain\ValueObjects\RestaurantClientId;
use CoverManager\Core\Shared\Domain\Enums\ClientIntegrationTypeEnum;
use CoverManager\Core\Shared\Domain\ValueObjects\Address;
use CoverManager\Core\Shared\Domain\ValueObjects\ClientIdentification;
use CoverManager\Core\Shared\Domain\ValueObjects\ClientIntegrationInfo;
use CoverManager\Core\Shared\Domain\ValueObjects\ClientPreferences;
use CoverManager\Core\Shared\Domain\ValueObjects\ClientStats;
use CoverManager\Core\Shared\Domain\ValueObjects\MarketingSubscription;
use CoverManager\Shared\Framework\Helpers\MixedHelper;
use stdClass;

final class RestaurantClientMapper
{
    /**
     * Maps a RestaurantClientModel to a RestaurantClient entity
     */
    public function hydrate(RestaurantClientModel|stdClass $model): RestaurantClient
    {
        // Create identification from individual fields
        $identification = new ClientIdentification(
            firstName: MixedHelper::getString($model->first_name ?? ''),
            lastName: MixedHelper::getStringOrNull($model->last_name ?? null),
            email: MixedHelper::getStringOrNull($model->email ?? null),
            phone: MixedHelper::getStringOrNull($model->phone ?? null),
            phoneCountryCode: MixedHelper::getStringOrNull($model->phone_country_code ?? null)
        );

        if ($model->preferences) {
            $preferencesData = MixedHelper::getArray($model->preferences);
            $preferences = new ClientPreferences(
                foodPreferences: MixedHelper::getStringOrNull($preferencesData['foodPreferences'] ?? null),
                foodRestrictions: MixedHelper::getStringOrNull($preferencesData['foodRestrictions'] ?? null),
                sittingPreferences: MixedHelper::getStringOrNull($preferencesData['sittingPreferences'] ?? null),
                waiterPreferences: MixedHelper::getStringOrNull($preferencesData['waiterPreferences'] ?? null),
                notes: MixedHelper::getStringOrNull($preferencesData['notes'] ?? null),
                accessibility: MixedHelper::getStringOrNull($preferencesData['accessibility'] ?? null)
            );
        } else {
            $preferences = null;
        }

        $stats = null;
        if ($model->stats) {
            $statsData = MixedHelper::getArray($model->stats);
            // Ensure that at least one of the stats fields is non-empty
            if (array_filter(array_values($statsData))) {
                $stats = new ClientStats(
                    bookings: MixedHelper::getIntOrNull($statsData['bookings'] ?? null),
                    bookingsCancellations: MixedHelper::getIntOrNull($statsData['bookingsCancellations'] ?? null),
                    bookingsNoShows: MixedHelper::getIntOrNull($statsData['bookingsNoShows'] ?? null),
                    bookingTotalSpending: MixedHelper::getIntOrNull($statsData['bookingTotalSpending'] ?? null),
                    bookingAverageSpending: MixedHelper::getIntOrNull($statsData['bookingAverageSpending'] ?? null),
                    OnTheGoes: MixedHelper::getIntOrNull($statsData['OnTheGoes'] ?? null),
                    totalEcommerce: MixedHelper::getIntOrNull($statsData['totalEcommerce'] ?? null),
                    eCommerces: MixedHelper::getIntOrNull($statsData['eCommerces'] ?? null),
                    firstBookingNoShowDate: MixedHelper::getIntOrNull($statsData['firstBookingNoShowDate'] ?? null),
                    firstBookingCancellationDate: MixedHelper::getIntOrNull($statsData['firstBookingCancellationDate'] ?? null),
                    firstBookingReservationDate: MixedHelper::getIntOrNull($statsData['firstBookingReservationDate'] ?? null),
                    averageRating: MixedHelper::getIntOrNull($statsData['averageRating'] ?? null)
                );
            }
        }
        $last3MonthsStats = null;
        if ($model->last_3_months_stats !== null) {
            $last3MonthsStatsData = MixedHelper::getArray($model->last_3_months_stats);
            if (array_filter(array_values($last3MonthsStatsData))) {
                $last3MonthsStats = new ClientStats(
                    bookings: MixedHelper::getIntOrNull($last3MonthsStatsData['bookings'] ?? null),
                    bookingsCancellations: MixedHelper::getIntOrNull($last3MonthsStatsData['bookingsCancellations'] ?? null),
                    bookingsNoShows: MixedHelper::getIntOrNull($last3MonthsStatsData['bookingsNoShows'] ?? null),
                    bookingTotalSpending: MixedHelper::getIntOrNull($last3MonthsStatsData['bookingTotalSpending'] ?? null),
                    bookingAverageSpending: MixedHelper::getIntOrNull($last3MonthsStatsData['bookingAverageSpending'] ?? null),
                    OnTheGoes: MixedHelper::getIntOrNull($last3MonthsStatsData['OnTheGoes'] ?? null),
                    totalEcommerce: MixedHelper::getIntOrNull($last3MonthsStatsData['totalEcommerce'] ?? null),
                    eCommerces: MixedHelper::getIntOrNull($last3MonthsStatsData['eCommerces'] ?? null),
                    firstBookingNoShowDate: MixedHelper::getIntOrNull($last3MonthsStatsData['firstBookingNoShowDate'] ?? null),
                    firstBookingCancellationDate: MixedHelper::getIntOrNull($last3MonthsStatsData['firstBookingCancellationDate'] ?? null),
                    firstBookingReservationDate: MixedHelper::getIntOrNull($last3MonthsStatsData['firstBookingReservationDate'] ?? null),
                    averageRating: MixedHelper::getIntOrNull($last3MonthsStatsData['averageRating'] ?? null)
                );
            }

        }


        $addressData = MixedHelper::getNonEmptyArray($model->address);
        $address = $addressData ? new Address(
            city: MixedHelper::getStringOrNull($addressData['city'] ?? null),
            address: MixedHelper::getStringOrNull($addressData['address'] ?? null),
            postalCode: MixedHelper::getStringOrNull($addressData['postalCode'] ?? null),
            countryCode: MixedHelper::getStringOrNull($addressData['countryCode'] ?? null),
            additionalPhone: MixedHelper::getStringOrNull($addressData['additionalPhone'] ?? null),
            additionalPhoneCountryCode: MixedHelper::getStringOrNull($addressData['additionalPhoneCountryCode'] ?? null)
        ) : null;

        $marketingSubscriptionData = MixedHelper::getArray($model->marketing_subscription);
        $marketingSubscription = new MarketingSubscription(
            optInAt: MixedHelper::getIntOrNull($marketingSubscriptionData['optInAt'] ?? null),
            optOutAt: MixedHelper::getIntOrNull($marketingSubscriptionData['optOutAt'] ?? null)
        );

        $integrations = [];
        if ($model->integrations) {
            /** @var array<array<mixed>> $integrationsData */
            $integrationsData = MixedHelper::getArray($model->integrations);
            foreach ($integrationsData as $integration) {
                $integrations[] = new ClientIntegrationInfo(
                    integration: ClientIntegrationTypeEnum::from(MixedHelper::getString($integration['integration'])),
                    id: MixedHelper::getString($integration['id'])
                );
            }
        }

        /** @var array<string,bool|float|int|string> $customProperties */
        $customProperties = MixedHelper::getArray($model->custom_properties ?? []);

        // RestaurantId is now required and non-nullable
        $restaurantId = new RestaurantId(MixedHelper::getString($model->restaurant_id ?? ''));

        $appClientId = new AppRestaurantClientId(
            app: AppEnum::from(MixedHelper::getString($model->app)),
            id: MixedHelper::getString($model->app_client_id ?? '')
        );


        return new RestaurantClient(
            id: new RestaurantClientId(MixedHelper::getString($model->id)),
            restaurantId: $restaurantId,
            appRestaurantClientId: $appClientId,
            status: RestaurantClientStatusEnum::from(MixedHelper::getString($model->status)),
            identification: $identification,
            preferences: $preferences,
            stats: $stats,
            last3MonthsStats: $last3MonthsStats,
            statsUpdatedAt: MixedHelper::getIntOrNull($model->stats_updated_at),
            addedAt: MixedHelper::getInt($model->added_at),
            language: MixedHelper::getStringOrNull($model->language),
            companyName: MixedHelper::getStringOrNull($model->company_name),
            address: $address,
            marketingSubscription: $marketingSubscription,
            integrations: $integrations,
            dob: MixedHelper::getStringOrNull($model->dob ?? null),
            customProperties: $customProperties
        )->hydrated();
    }

    /**
     * Maps a RestaurantClient entity to an array for database storage
     *
     * @return array<string, mixed>
     */
    public function extract(RestaurantClient $entity): array
    {
        $result = [
            'id' => $entity->id->getValue(),
            'app' => $entity->appRestaurantClientId->app->value,
            'app_client_id' => $entity->appRestaurantClientId->id,
            'status' => $entity->status->value,
            'preferences' => MixedHelper::safeCleanJsonOrNull($entity->preferences),
            'stats' => MixedHelper::safeCleanJsonOrNull($entity->stats),
            'last_3_months_stats' => MixedHelper::safeJson($entity->last3MonthsStats),
            'stats_updated_at' => $entity->statsUpdatedAt,
            'language' => $entity->language,
            'company_name' => $entity->companyName,
            'address' => MixedHelper::safeCleanJsonOrNull($entity->address),
            'marketing_subscription' => MixedHelper::safeCleanJsonOrNull($entity->marketingSubscription),
            'integrations' => MixedHelper::safeCleanJsonOrNull($entity->integrations),
            'added_at' => $entity->addedAt,
            'dob' => $entity->dob,
            'custom_properties' => MixedHelper::safeCleanJsonOrNull($entity->customProperties),
            'restaurant_id' => $entity->restaurantId->value()
        ];

        // Add individual identification fields
        if ($entity->identification) {
            $result['first_name'] = $entity->identification->firstName;
            $result['last_name'] = $entity->identification->lastName;
            $result['email'] = $entity->identification->email;
            $result['phone'] = $entity->identification->phone;
            $result['phone_country_code'] = $entity->identification->phoneCountryCode;
        } else {
            $result['first_name'] = '';
            $result['last_name'] = null;
            $result['email'] = null;
            $result['phone'] = null;
            $result['phone_country_code'] = null;
        }

        return $result;
    }
}
