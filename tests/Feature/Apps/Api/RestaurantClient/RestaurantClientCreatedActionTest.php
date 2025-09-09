<?php

declare(strict_types=1);

namespace Tests\Feature\Apps\Api\RestaurantClient;

use Apps\Api\RestaurantClient\ClientCreated\RestaurantClientCreatedAction;
use Apps\Api\RestaurantClient\ClientCreated\RestaurantClientCreatedDto;
use CoverManager\App\Domain\Enums\AppEnum;
use CoverManager\Core\RestaurantClient\Domain\ValueObjects\AppRestaurantClientId;
use CoverManager\Cover\Client\Application\Queries\GetById\GetCoverClientByIdQuery;
use CoverManager\Shared\Framework\Infrastructure\Bus\QueryBus\QueryBus;
use Faker\Factory;
use Tests\Feature\Src\Core\Restaurant\RestaurantMother;
use Tests\Feature\Src\Cover\Client\CoverClientRMMother;
use Tests\Unit\CoverTestCase;

/**
 * Tests for the RestaurantClientCreatedAction
 * We will test that after the creation of a restaurant client, info is propagated from cover to the crm
 */
class RestaurantClientCreatedActionTest extends CoverTestCase
{

    protected function setUp(): void
    {
        parent::setUp();

    }

    public function testRestaurantClientCreatedActionWithCoverManagerApp(): void
    {
        // having
        $faker = Factory::create();
        $id = $faker->randomNumber(6);
        $restaurant = RestaurantMother::random();
        $appRestaurantClientId = new AppRestaurantClientId(AppEnum::coverManager, (string)$id);
        $requestDto = new RestaurantClientCreatedDto($appRestaurantClientId);
        /** @var RestaurantClientCreatedAction $action */
        $action = app(RestaurantClientCreatedAction::class);

        $coverDto = CoverClientRMMother::random(id: $id, restaurantId: (int)$restaurant->appRestaurantId->id);

        QueryBus::$routes[GetCoverClientByIdQuery::class] = static function () use ($coverDto) {
            return $coverDto;
        };
        $action($requestDto);
        $this->assertDatabaseHas('crm_restaurant_clients', ['app_client_id' => $id]);
        $this->assertDatabaseHas('crm_restaurants', ['id' => $restaurant->id->value()]);

    }

    public function testRestaurantClientCreatedActionWithNonCoverManagerApp(): void
    {
        // Arrange
        $appRestaurantClientId = new AppRestaurantClientId(AppEnum::premiumGuest, 'test-id');
        $dto = new RestaurantClientCreatedDto($appRestaurantClientId);
        $action = new RestaurantClientCreatedAction($this->commandBus);

        // The command bus should not be called when the app is not coverManager
        $this->commandBus->expects($this->never())
            ->method('dispatchProcess');

        // Act
        $action($dto);

        // No assertions needed as we're verifying the mock expectations
    }
}
