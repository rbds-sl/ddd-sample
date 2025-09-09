<?php

namespace Tests\Feature\Src\Cover\Client;

use CoverManager\Core\Shared\Domain\ValueObjects\Address;
use CoverManager\Core\Shared\Domain\ValueObjects\ClientIdentification;
use CoverManager\Core\Shared\Domain\ValueObjects\MarketingSubscription;
use CoverManager\Cover\Client\Domain\ReadModels\CoverClientRM;
use Faker\Factory;

class CoverClientRMMother
{
    public static function random(int $id, ?int $restaurantId = null): CoverClientRM
    {
        $faker = Factory::create();
        return new CoverClientRM(
            id: $id,
            restaurantId: $restaurantId ?? $faker->randomNumber(),
            marketingSubscription: new MarketingSubscription(),
            identification: new ClientIdentification(
                firstName: $faker->firstName(),
                lastName: $faker->lastName(),
                email: $faker->email(),
                phone: $faker->phoneNumber()
            ),
            language: $faker->languageCode,
            companyName: $faker->company(),
            address: new Address(
                city: $faker->city,
                address: $faker->streetAddress,
                postalCode: $faker->postcode,
                countryCode: $faker->countryCode,
                additionalPhone: $faker->phoneNumber,
                additionalPhoneCountryCode: $faker->countryCode
            ),
            integrations: [],
            dob: $faker->date(),
            customProperties: [],
            addedAt: $faker->unixTime()
        );
    }
}