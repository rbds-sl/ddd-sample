<?php

declare(strict_types=1);

namespace Tests\Feature\Apps\Api\Booking;

use Apps\Api\Booking\BookingCreated\BookingCreatedAction;
use Apps\Api\Booking\BookingCreated\BookingCreatedDto;
use CoverManager\App\Domain\Enums\AppEnum;
use CoverManager\Core\Booking\Domain\ValueObjects\AppBookingId;
use CoverManager\Cover\Booking\Application\Queries\GetById\GetCoverBookingByIdQuery;
use CoverManager\Cover\Client\Application\Queries\GetById\GetCoverClientByIdQuery;
use CoverManager\Shared\Framework\Infrastructure\Bus\QueryBus\QueryBus;
use Faker\Factory;
use Tests\Feature\Src\Core\Restaurant\RestaurantMother;
use Tests\Feature\Src\Cover\Booking\CoverBookingRMMother;
use Tests\Feature\Src\Cover\Client\CoverClientRMMother;
use Tests\Unit\CoverTestCase;

/**
 * Tests for the BookingCreatedAction
 * We will test that after the creation of a booking, info is propagated from cover to the crm
 */
class BookingCreatedActionTest extends CoverTestCase
{

    public function testBookingCreatedActionWithCoverManagerApp(): void
    {
        // Arrange

        $faker = Factory::create();
        $clientId = $faker->randomNumber(6);
        $restaurant = RestaurantMother::random();

        $this->assertDatabaseHas('crm_restaurants', ['id' => $restaurant->id->value()]);
        $coverBookingDto = CoverBookingRMMother::random(clientId: $clientId, restaurantId: (int)$restaurant->appRestaurantId->id);
        $appBookingId = new AppBookingId(AppEnum::coverManager, (string)$coverBookingDto->bookingId);
        $requestDto = new BookingCreatedDto($appBookingId);
        $action = new BookingCreatedAction($this->commandBus);

        QueryBus::$routes[GetCoverBookingByIdQuery::class] = static function () use ($coverBookingDto) {
            return $coverBookingDto;
        };

        $coverClientDto = CoverClientRMMother::random(id: $clientId, restaurantId: (int)$restaurant->appRestaurantId->id);

        QueryBus::$routes[GetCoverClientByIdQuery::class] = static function () use ($coverClientDto) {
            return $coverClientDto;
        };

        // Act
        $action($requestDto);
        $this->assertDatabaseHas('crm_bookings', ['app_booking_id' => $appBookingId->id]);
    }

}