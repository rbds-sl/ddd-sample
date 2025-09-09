<?php

declare(strict_types=1);

namespace CoverManager\Core\Restaurant\Application\Queries\FindByAppId;

use CoverManager\Core\Restaurant\Application\Queries\Shared\RestaurantDto;
use CoverManager\Core\Restaurant\Domain\Repositories\RestaurantRepositoryInterface;
use CoverManager\Shared\Framework\Infrastructure\Bus\QueryBus\QueryHandlerInterface;

final readonly class FindRestaurantByAppIdHandler implements QueryHandlerInterface
{
    public function __construct(
        private RestaurantRepositoryInterface $repository
    ) {
    }

    /**
     * @param  FindRestaurantByAppIdQuery  $query
     * @return RestaurantDto|null
     */
    public function __invoke(FindRestaurantByAppIdQuery $query): ?RestaurantDto
    {
        $restaurant = $this->repository->findByAppRestaurantId($query->id);

        if (!$restaurant) {
            return null;
        }

        return new RestaurantDto(
            id: $restaurant->id,
            appRestaurantId: $restaurant->appRestaurantId,
            name: $restaurant->name,
            status: $restaurant->status
        );
    }
}
