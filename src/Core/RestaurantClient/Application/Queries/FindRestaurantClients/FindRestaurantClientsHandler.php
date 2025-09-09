<?php

declare(strict_types=1);

namespace CoverManager\Core\RestaurantClient\Application\Queries\FindRestaurantClients;

use CoverManager\Core\RestaurantClient\Application\Queries\Common\RestaurantClientDto;
use CoverManager\Core\RestaurantClient\Application\Queries\Common\RestaurantClientDtoMapper;
use CoverManager\Core\RestaurantClient\Domain\Entities\RestaurantClient;
use CoverManager\Core\RestaurantClient\Domain\Repositories\RestaurantClientRepositoryInterface;
use CoverManager\Shared\Framework\Infrastructure\Bus\QueryBus\QueryHandlerInterface;

final readonly class FindRestaurantClientsHandler implements QueryHandlerInterface
{
    public function __construct(
        private RestaurantClientRepositoryInterface $repository
    ) {
    }


    /**
     * @param  FindRestaurantClientsQuery  $query
     * @return array<RestaurantClientDto>
     */
    public function __invoke(FindRestaurantClientsQuery $query): array
    {
        $restaurantClients = $this->repository->findByRestaurantId(
            restaurantId: $query->restaurantId,
            limit: $query->limit,
            offset: $query->offset
        );

        return array_map(
            static fn (RestaurantClient $client) => RestaurantClientDtoMapper::mapToDto($client),
            $restaurantClients
        );
    }
}
