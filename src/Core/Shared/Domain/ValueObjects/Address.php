<?php

declare(strict_types=1);

namespace CoverManager\Core\Shared\Domain\ValueObjects;

final readonly class Address
{
    public function __construct(
        public ?string $city = null,
        public ?string $address = null,
        public ?string $postalCode = null,
        public ?string $countryCode = null,
        public ?string $additionalPhone = null,
        public ?string $additionalPhoneCountryCode = null,
    ) {

    }

    public function merge(
        ?string $country,
        ?string $address,
        ?string $postalCode,
        ?string $city,
        ?string $additionalPhone,
        ?string $additionalPhoneCountryCode
    ): self {
        $instance = new self(
            city: $city ?? $this->city,
            address: $address ?? $this->address,
            postalCode: $postalCode ?? $this->postalCode,
            countryCode: $country ?? $this->countryCode,
            additionalPhone: $additionalPhone ?? $this->additionalPhone,
            additionalPhoneCountryCode: $additionalPhoneCountryCode ?? $this->additionalPhoneCountryCode
        );
        if ($instance->isEmpty()) {
            return new self();
        }
        return $instance;
    }

    private function isEmpty(): bool
    {
        return empty($this->city) &&
            empty($this->address) &&
            empty($this->postalCode) &&
            empty($this->countryCode) &&
            empty($this->additionalPhone) &&
            empty($this->additionalPhoneCountryCode);
    }

}
