<?php

namespace Tests\Feature\Src\Cover\Booking;

use CoverManager\Cover\Booking\Domain\Enums\CoverBookingClientTypeEnum;
use CoverManager\Cover\Booking\Domain\Enums\CoverBookingConfirmationStatusEnum;
use CoverManager\Cover\Booking\Domain\Enums\CoverBookingPaymentTypeEnum;
use CoverManager\Cover\Booking\Domain\Enums\CoverBookingStatusEnum;
use CoverManager\Cover\Booking\Domain\Enums\CoverBookingTypeEnum;
use CoverManager\Cover\Booking\Domain\Enums\CoverPaymentCurrencyEnum;
use CoverManager\Cover\Booking\Domain\Enums\CoverPaymentMethodEnum;
use CoverManager\Cover\Booking\Domain\Enums\CoverPaymentSourceEnum;
use CoverManager\Cover\Booking\Domain\ReadModels\CoverBookingRM;
use CoverManager\Shared\Framework\Helpers\MixedHelper;
use Faker\Factory;

class CoverBookingRMMother
{
    public static function random(int $clientId,int $restaurantId): CoverBookingRM
    {
        $faker = Factory::create();

        $hasPayment = $faker->boolean(30); // 30% of cases have payment info
        /** @var CoverBookingPaymentTypeEnum $paymentType */
        $paymentType = $hasPayment
            ? $faker->randomElement([
                CoverBookingPaymentTypeEnum::DEPOSIT,
                CoverBookingPaymentTypeEnum::PRE_AUTH,
                CoverBookingPaymentTypeEnum::GUARANTEE,
            ])
            : CoverBookingPaymentTypeEnum::FREE;

        $initialPayedAmount = $hasPayment ? $faker->numberBetween(100, 10000) : 0; // cents
        $totalPayedAmount = $hasPayment ? $faker->numberBetween($initialPayedAmount, $initialPayedAmount + 5000) : null;
        $totalRefundedAmount = $hasPayment && $faker->boolean(20) ? $faker->numberBetween(0, (int)($totalPayedAmount ?? 0)) : null;

        /** @var CoverPaymentCurrencyEnum $paymentCurrency */
        $paymentCurrency = $hasPayment ? $faker->randomElement(CoverPaymentCurrencyEnum::cases()) : null;
        /** @var CoverPaymentMethodEnum $paymentMethod */
        $paymentMethod = $hasPayment ? $faker->randomElement(CoverPaymentMethodEnum::cases()) : null;

        /** @var CoverPaymentSourceEnum $paymentSource */
        $paymentSource = $hasPayment ? $faker->randomElement(CoverPaymentSourceEnum::cases()) : null;

        /** @var CoverBookingStatusEnum  $status  */
        $status = $faker->randomElement(CoverBookingStatusEnum::cases());
        /** @var CoverBookingConfirmationStatusEnum  $confirmationStatus */
        $confirmationStatus = $faker->randomElement(CoverBookingConfirmationStatusEnum::cases());
        /** @var CoverBookingTypeEnum $type */
        $type = $faker->randomElement(CoverBookingTypeEnum::cases());
        /** @var CoverBookingClientTypeEnum $clientType */
        $clientType = $faker->randomElement(CoverBookingClientTypeEnum::cases());

        $date = $faker->date('Y-m-d', '+1 month');

        /** @var string $time */
        $time = $faker->randomElement(['12:00', '13:30', '19:00', '20:30', '21:15']);

        $createdOn = time();

        return new CoverBookingRM(
            bookingId: $faker->numberBetween(1, 9_999_999),
            token: $faker->uuid(),
            status: $status,
            customStatus: $status->value,
            type: $type,
            restaurantId: $restaurantId,
            clientId: $clientId,
            clientType: $clientType,
            date: $date,
            time: $time,
            partySize: $faker->numberBetween(1, 12),
            groupBooking: $faker->boolean(),
            channel: MixedHelper::getString($faker->randomElement(['web', 'phone', 'walk_in', 'app'])),
            duration: $faker->optional(0.6)->numberBetween(30, 240),
            createdOn: $createdOn,
            paymentType: $paymentType,
            cancellationFee: $faker->optional(0.2)->numberBetween(0, 5000),
            initialPayedAmount: $initialPayedAmount,
            totalPayedAmount: $totalPayedAmount,
            totalRefundedAmount: $totalRefundedAmount,
            paymentCurrency: $paymentCurrency,
            paymentMethod: $paymentMethod,
            paymentSource: $paymentSource,
            referral: MixedHelper::getString($faker->optional(0.3)->randomElement(['instagram', 'facebook', 'google', 'newsletter'])),
            confirmationStatus: $confirmationStatus,
            cancelledAt: null,
            seatedAt: null,
            unseatedAt: null,
            payedAt: null,
            ip: $faker->optional(0.5)->ipv4(),
            testing: true,
        );
    }
}