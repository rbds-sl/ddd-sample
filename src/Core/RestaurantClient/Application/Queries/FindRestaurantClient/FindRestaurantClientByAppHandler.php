<?php

declare(strict_types=1);

namespace CoverManager\Core\RestaurantClient\Application\Queries\FindRestaurantClient;

use CoverManager\Core\RestaurantClient\Application\Queries\Common\RestaurantClientDto;
use CoverManager\Core\RestaurantClient\Application\Queries\Common\RestaurantClientDtoMapper;
use CoverManager\Core\RestaurantClient\Domain\Repositories\RestaurantClientRepositoryInterface;
use CoverManager\Shared\Framework\Infrastructure\Bus\QueryBus\QueryHandlerInterface;

final readonly class FindRestaurantClientByAppHandler implements QueryHandlerInterface
{
    public function __construct(
        private RestaurantClientRepositoryInterface $repository
    ) {
    }

    public function __invoke(FindRestaurantClientByAppQuery $query): ?RestaurantClientDto
    {
        $client = $this->repository->findByAppClientId($query->appRestaurantClientId);
        if ($client === null) {

            return null;
        }
        return RestaurantClientDtoMapper::mapToDto($client);

    }

}
