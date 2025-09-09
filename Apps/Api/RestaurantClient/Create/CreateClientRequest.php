<?php

declare(strict_types=1);

namespace Apps\Api\RestaurantClient\Create;

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

final class CreateClientRequest extends AbstractFormRequest
{
    public function getCommand(): CreateRestaurantClientCommand
    {
        $app = AppEnum::from($this->getHelper()->getString('app'));

        $identification = $this->getHelper()->getArray('identification');
        $preferencesData = $this->getHelper()->getArray('preferences');
        $addressData = $this->getHelper()->getArray('address');
        $marketingData = $this->getHelper()->getArray('marketingSubscription');

        $marketingSubscription = new MarketingSubscription(
            optInAt: MixedHelper::getIntOrNull($marketingData['optInAt'] ?? null),
            optOutAt: MixedHelper::getIntOrNull($marketingData['optOutAt'] ?? null)
        );

        /** @var array<string,bool|float|int|string> $customProperties */
        $customProperties = $this->getHelper()->getArray('customProperties');

        $integrations = [];

        return new CreateRestaurantClientCommand(
            id: RestaurantClientId::random(),
            restaurantId: RestaurantId::create($this->getHelper()->getInt('restaurantId')),
            clientId: new AppRestaurantClientId(app: $app, id: $this->getHelper()->getString('clientId')),
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
            statsUpdatedAt: null,
            language: $this->getHelper()->getStringOrNull('language'),
            companyName: $this->getHelper()->getStringOrNull('companyName'),
            address: new Address(
                city: MixedHelper::getStringOrNull($addressData['city'] ?? null),
                address: MixedHelper::getStringOrNull($addressData['address'] ?? null),
                postalCode: MixedHelper::getStringOrNull($addressData['postalCode'] ?? null),
                countryCode: MixedHelper::getStringOrNull($addressData['countryCode'] ?? null),
                additionalPhone: MixedHelper::getStringOrNull($addressData['additionalPhone'] ?? null),
                additionalPhoneCountryCode: MixedHelper::getStringOrNull($addressData['additionalPhoneCountryCode'] ?? null)
            ),
            integrations: $integrations,
            dob: $this->getHelper()->getStringOrNull('dob'),
            customProperties: $customProperties,
            addedAt: $this->getHelper()->getIntOrNull('addedAt')
        );
    }
}
