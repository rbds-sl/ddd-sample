<?php

namespace Tests\Feature\Src\Core\Restaurant;

use CoverManager\App\Domain\Enums\AppEnum;
use CoverManager\Core\Restaurant\Application\Commands\Create\CreateRestaurantCommand;
use CoverManager\Core\Restaurant\Application\Queries\GetById\GetRestaurantByIdQuery;
use CoverManager\Core\Restaurant\Application\Queries\Shared\RestaurantDto;
use CoverManager\Core\Restaurant\Domain\ValueObjects\AppRestaurantId;
use CoverManager\Core\Restaurant\Domain\ValueObjects\RestaurantId;
use CoverManager\Core\RestaurantClient\Domain\ValueObjects\AppRestaurantClientId;
use CoverManager\Shared\Framework\Infrastructure\Bus\CommandBus\CommandBusInterface;
use CoverManager\Shared\Framework\Infrastructure\Bus\QueryBus\QueryBusInterface;
use Tests\Unit\Shared\FakerMother;

class RestaurantMother
{
    public static function random(AppEnum $appEnum = AppEnum::coverManager): RestaurantDto
    {
        /** @var CommandBusInterface $commandBus */
        $commandBus = app(CommandBusInterface::class);

        $id = RestaurantId::random();
        $appRestaurantId = new AppRestaurantId($appEnum, FakerMother::integer());
        $command = new CreateRestaurantCommand(
            id: $id,
            appRestaurantId: $appRestaurantId,
            name: FakerMother::name()
        );
        $commandBus->dispatch($command);

        /** @var QueryBusInterface $queryBus */
        $queryBus = app(QueryBusInterface::class);
        return $queryBus->query(new GetRestaurantByIdQuery($id));

    }

}