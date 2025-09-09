<?php

declare(strict_types=1);

namespace CoverManager\Core\Shared\Domain\ValueObjects;

use CoverManager\Shared\Framework\Helpers\NameHelper;
use CoverManager\Shared\Framework\Helpers\Phone\PhoneHelper;

final readonly class ClientIdentification
{
    public string $firstName;
    public ?string $lastName;
    public ?string $email;
    public ?string $phone;
    public ?string $phoneCountryCode;

    public function __construct(
        string $firstName,
        ?string $lastName = null,
        ?string $email = null,
        ?string $phone = null,
        ?string $phoneCountryCode = null,
    ) {
        if ($firstName) {
            $firstName = trim($firstName);
        }

        if ($firstName === '.') {
            $firstName = '';
        }

        if ($lastName) {
            $lastName = trim($lastName);
        }

        if ($lastName === '' || $lastName === '.') {
            $lastName = null;
        }
        if ($email) {
            $email = trim($email);
        }
        if ($email === '') {
            $email = null;
        }
        $this->email = $email;
        if ($phoneCountryCode) {
            $phoneCountryCode = str_replace('+', '', $phoneCountryCode);
            $phoneCountryCode = trim($phoneCountryCode);
        }
        $this->phoneCountryCode = $phoneCountryCode;


        if ($phone) { //if the phone starts with country code we should clean it twice
            $phone = PhoneHelper::sanitizePhone(phone: $phone, countryPhoneCode: $phoneCountryCode);
            $phone = PhoneHelper::sanitizePhone(phone: $phone, countryPhoneCode: $phoneCountryCode);
        }
        if ($phone === '') {
            $phone = null;
        }
        $this->phone = $phone;

        /** If the name or lastName are empty, let's do some magic */
        if ($firstName === '' || $lastName === null) {
            [$firstName, $lastName] = NameHelper::explode($firstName . $lastName);
        }

        $this->firstName = trim($firstName);
        $this->lastName = trim($lastName);

    }

    public function merge(
        ?string $name,
        ?string $lastName,
        ?string $email,
        ?string $phone,
        ?string $phoneCountryCode
    ): self {
        return new self(
            firstName: $name ?? $this->firstName,
            lastName: $lastName ?? $this->lastName,
            email: $email ?? $this->email,
            phone: $phone ?? $this->phone,
            phoneCountryCode: $phoneCountryCode ?? $this->phoneCountryCode
        );
    }
}
