<?php

declare(strict_types=1);

namespace CoverManager\Core\Restaurant\Application\Queries\GetByAppId;

use CoverManager\Core\Restaurant\Application\Queries\Shared\RestaurantDto;
use CoverManager\Core\Restaurant\Domain\Repositories\RestaurantRepositoryInterface;
use CoverManager\Shared\Framework\Infrastructure\Bus\QueryBus\QueryHandlerInterface;

final readonly class GetRestaurantByAppIdHandler implements QueryHandlerInterface
{
    public function __construct(
        private RestaurantRepositoryInterface $repository
    ) {
    }

    /**
     * @param  GetRestaurantByAppIdQuery  $query
     * @return RestaurantDto
     */
    public function __invoke(GetRestaurantByAppIdQuery $query): RestaurantDto
    {
        $restaurant = $this->repository->getByAppId($query->id);

        return new RestaurantDto(
            id: $restaurant->id,
            appRestaurantId: $restaurant->appRestaurantId,
            name: $restaurant->name,
            status: $restaurant->status
        );
    }
}
