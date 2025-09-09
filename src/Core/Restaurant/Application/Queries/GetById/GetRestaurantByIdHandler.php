<?php

declare(strict_types=1);

namespace CoverManager\Core\Restaurant\Application\Queries\GetById;

use CoverManager\Core\Restaurant\Application\Queries\Shared\RestaurantDto;
use CoverManager\Core\Restaurant\Domain\Repositories\RestaurantRepositoryInterface;
use CoverManager\Shared\Framework\Infrastructure\Bus\QueryBus\QueryHandlerInterface;

final readonly class GetRestaurantByIdHandler implements QueryHandlerInterface
{
    public function __construct(
        private RestaurantRepositoryInterface $repository
    ) {
    }

    /**
     * @param  GetRestaurantByIdQuery  $query
     * @return RestaurantDto
     */
    public function __invoke(GetRestaurantByIdQuery $query): RestaurantDto
    {
        $restaurant = $this->repository->getById($query->id);

        return new RestaurantDto(
            id: $query->id,
            appRestaurantId: $restaurant->appRestaurantId,
            name: $restaurant->name,
            status: $restaurant->status
        );
    }
}
