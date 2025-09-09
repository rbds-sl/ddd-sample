<?php

namespace Tests\Feature\Src\Core\RestaurantClient\Application\Commands\Update;

use CoverManager\App\Domain\Enums\AppEnum;
use CoverManager\Core\Restaurant\Application\Commands\Create\CreateRestaurantCommand;
use CoverManager\Core\Restaurant\Domain\ValueObjects\AppRestaurantId;
use CoverManager\Core\Restaurant\Domain\ValueObjects\RestaurantId;
use CoverManager\Core\RestaurantClient\Application\Commands\Create\CreateRestaurantClientCommand;
use CoverManager\Core\RestaurantClient\Domain\Exceptions\SameClientException;
use CoverManager\Core\RestaurantClient\Domain\Repositories\RestaurantClientRepositoryInterface;
use CoverManager\Core\RestaurantClient\Domain\ValueObjects\AppRestaurantClientId;
use CoverManager\Core\RestaurantClient\Domain\ValueObjects\RestaurantClientId;
use CoverManager\Core\Shared\Domain\ValueObjects\ClientIdentification;
use CoverManager\Core\Shared\Domain\ValueObjects\MarketingSubscription;
use CoverManager\Shared\Framework\Helpers\Container;
use CoverManager\Shared\Framework\Infrastructure\Bus\CommandBus\CommandBusInterface;
use Faker\Factory;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Support\Str;

class UpdateRestaurantClientHandlerTest extends TestCase
{
    public function testUpdateRestaurantClientHandler(): void
    {
        $faker = Factory::create();
        $commandBus = Container::getObjectInstance(CommandBusInterface::class);
        $createRestaurantCommand = new CreateRestaurantCommand(
            id: RestaurantId::random(),
            appRestaurantId: new AppRestaurantId(AppEnum::coverManager, Str::ulid()),
            name: $faker->name,
        );
        $commandBus->dispatch($createRestaurantCommand);
        $appClientId = Str::ulid();
        $identification = new ClientIdentification(
            firstName: $faker->firstName,
            lastName: $faker->lastName,
            email: $faker->email,
            phone: $faker->phoneNumber,
        );
        $createCommand = new CreateRestaurantClientCommand(
            id: RestaurantClientId::random(),
            restaurantId: $createRestaurantCommand->id,
            clientId: new AppRestaurantClientId(AppEnum::coverManager, $appClientId),
            marketingSubscription: new MarketingSubscription(),
            identification: $identification
        );
        $commandBus->dispatch($createCommand);

        $restauranClientRepository = Container::getObjectInstance(RestaurantClientRepositoryInterface::class);
        $client=$restauranClientRepository->getById($createCommand->id);
        $this->expectException(SameClientException::class);
        $client->updateUnique(
            marketingSubscription: $createCommand->marketingSubscription,
            identification: $createCommand->identification,
        );
    }

}
