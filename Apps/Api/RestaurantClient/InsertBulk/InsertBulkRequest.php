<?php

declare(strict_types=1);

namespace Apps\Api\RestaurantClient\InsertBulk;

use Apps\Shared\Http\AbstractFormRequest;
use CoverManager\App\Domain\Enums\AppEnum;
use CoverManager\Core\Restaurant\Domain\ValueObjects\RestaurantId;
use CoverManager\Core\RestaurantClient\Application\Commands\Create\CreateRestaurantClientCommand;
use CoverManager\Core\RestaurantClient\Domain\ValueObjects\AppRestaurantClientId;
use CoverManager\Core\RestaurantClient\Domain\ValueObjects\RestaurantClientId;
use CoverManager\Core\Shared\Domain\ValueObjects\Address;
use CoverManager\Core\Shared\Domain\ValueObjects\ClientIdentification;
use CoverManager\Core\Shared\Domain\ValueObjects\ClientPreferences;
use CoverManager\Core\Shared\Domain\ValueObjects\MarketingSubscription;
use CoverManager\Shared\Framework\Helpers\MixedHelper;

final class InsertBulkRequest extends AbstractFormRequest
{
    /**
     * @return array<CreateRestaurantClientCommand>
     */
    public function getClients(): array
    {
        $result = [];
        /** @var array<array<mixed>> $clients */
        $clients = $this->getHelper()->getArray('clients');
        $app = AppEnum::from($this->getHelper()->getString('app'));

        foreach ($clients as $client) {
            // Get identification data
            $identification = MixedHelper::getArray($client['identification'] ?? []);

            // Get preferences data
            $preferencesData = MixedHelper::getArray($client['preferences'] ?? []);

            // Get address data
            $addressData = MixedHelper::getArray($client['address'] ?? []);

            // Get marketing subscription data
            $marketingData = MixedHelper::getArray($client['marketingSubscription'] ?? []);

            // Initialize marketing subscription
            $marketingSubscription = new MarketingSubscription(
                optInAt: MixedHelper::getIntOrNull($marketingData['optInAt'] ?? null),
                optOutAt: MixedHelper::getIntOrNull($marketingData['optOutAt'] ?? null)
            );

            /** @var array<string,bool|float|int|string> $customProperties */
            $customProperties = MixedHelper::getArray($client['customProperties'] ?? []);

            // Initialize integrations
            $integrations = [];

            $result[] = new CreateRestaurantClientCommand(
                id: RestaurantClientId::random(),
                restaurantId: RestaurantId::create(MixedHelper::getInt($client['restaurantId'])),
                clientId: new AppRestaurantClientId(app:$app, id:MixedHelper::getString($client['clientId'])),
                marketingSubscription: $marketingSubscription,
                identification: new ClientIdentification(
                    firstName: MixedHelper::getString($identification['firstName'] ?? ''),
                    lastName: MixedHelper::getStringOrNull($identification['lastName'] ?? null),
                    email: MixedHelper::getStringOrNull($identification['email'] ?? null),
                    phone: MixedHelper::getStringOrNull($identification['phone'] ?? null),
                    phoneCountryCode: MixedHelper::getStringOrNull($identification['phoneCountryCode'] ?? null)
                ),
                preferences: new ClientPreferences(
                    foodPreferences: MixedHelper::getStringOrNull($preferencesData['foodPreferences'] ?? null),
                    foodRestrictions: MixedHelper::getStringOrNull($preferencesData['foodRestrictions'] ?? null),
                    sittingPreferences: MixedHelper::getStringOrNull($preferencesData['sittingPreferences'] ?? null),
                    waiterPreferences: MixedHelper::getStringOrNull($preferencesData['waiterPreferences'] ?? null),
                    notes: MixedHelper::getStringOrNull($preferencesData['notes'] ?? null),
                    accessibility: MixedHelper::getStringOrNull($preferencesData['accessibility'] ?? null)
                ),
                stats: null,
                last3MonthsStats: null,
                statsUpdatedAt:  null,
                language: MixedHelper::getStringOrNull($client['language'] ?? null),
                companyName: MixedHelper::getStringOrNull($client['companyName'] ?? null),
                address: new Address(
                    city: MixedHelper::getStringOrNull($addressData['city'] ?? null),
                    address: MixedHelper::getStringOrNull($addressData['address'] ?? null),
                    postalCode: MixedHelper::getStringOrNull($addressData['postalCode'] ?? null),
                    countryCode: MixedHelper::getStringOrNull($addressData['countryCode'] ?? null),
                    additionalPhone: MixedHelper::getStringOrNull($addressData['additionalPhone'] ?? null),
                    additionalPhoneCountryCode: MixedHelper::getStringOrNull($addressData['additionalPhoneCountryCode'] ?? null)
                ),
                integrations: $integrations,
                dob: MixedHelper::getStringOrNull($client['dob'] ?? null),
                customProperties: $customProperties,
                addedAt: $client['addedAt'] ?? null
            );
        }
        return $result;
    }

}
