<?php

declare(strict_types=1);

namespace CoverManager\Shared\Framework\Helpers\Phone;

use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberUtil;

final class PhoneHelper
{
    /**
     * Will remove 0 at the beginning of the phone number and return the national number.
     * @param  string|null  $phone
     * @param  string|null  $countryPhoneCode
     * @return string|null
     */
    public static function sanitizePhone(?string $phone, ?string $countryPhoneCode = null): ?string
    {
        if (!$phone) {
            return null;
        }
        try {
            $phoneUtil = PhoneNumberUtil::getInstance();
            $country   = null;
            if ($countryPhoneCode) {
                $country = $phoneUtil->getRegionCodeForCountryCode((int) str_replace(['+', ' ', '(', ')', '[', ']'], '', $countryPhoneCode));
            }
            $phoneObject = $phoneUtil->parse($phone, $country);
            return ltrim($phoneObject->getNationalNumber() ?? '', '0');
        } catch (NumberParseException) {
            return self::clearPhone($phone);
        }
    }

    public static function clearPhone(?string $phone): ?string
    {
        if (empty($phone)) {
            return null;
        }
        return str_replace([' ', '-', '.', '+', '(', ')', '[', ']'], '', $phone);
    }

    public static function fromPhoneNumber(string $phoneNumber, ?string $defaultRegion = null): ?PhoneDto
    {
        try {
            $phoneUtil   = PhoneNumberUtil::getInstance();
            $phoneObject = $phoneUtil->parse($phoneNumber, $defaultRegion);

            $phone  = $phoneObject->getNationalNumber();
            $prefix = $phoneObject->getCountryCode();

            if (null === $phone || null === $prefix) {
                return null;
            }

            return new PhoneDto($phone, $prefix);
        } catch (NumberParseException) {
            return null;
        }
    }

    public static function getCountryCode(?string $phone): ?string
    {
        if (!$phone) {
            return null;
        }
        try {
            $phoneUtil   = PhoneNumberUtil::getInstance();
            $phoneObject = $phoneUtil->parse($phone);
            return $phoneUtil->getRegionCodeForNumber($phoneObject);
        } catch (NumberParseException) {
            return null;
        }
    }

    public static function isTheSamePhone(?string $phoneCountryCode1, ?string $phone1, ?string $phoneCountryCode2, ?string $phone2): bool
    {
        if ($phoneCountryCode1 === null || $phoneCountryCode2 === null) {
            return false;
        }
        if ($phone1 === null || $phone2 === null) {
            return false;
        }
        if ($phoneCountryCode1 !== $phoneCountryCode2) {
            return false;
        }
        if (self::sanitizePhone($phone1) !== self::sanitizePhone($phone2)) {
            return false;
        }
        return true;
    }
}
