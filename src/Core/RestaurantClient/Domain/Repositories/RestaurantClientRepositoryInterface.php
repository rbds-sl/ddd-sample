<?php

declare(strict_types=1);

namespace CoverManager\Core\RestaurantClient\Domain\Repositories;

use CoverManager\App\Domain\Enums\AppEnum;
use CoverManager\Core\Restaurant\Domain\ValueObjects\RestaurantId;
use CoverManager\Core\RestaurantClient\Domain\Entities\RestaurantClient;
use CoverManager\Core\RestaurantClient\Domain\ValueObjects\AppRestaurantClientId;
use CoverManager\Core\RestaurantClient\Domain\ValueObjects\RestaurantClientId;

interface RestaurantClientRepositoryInterface
{
    /**
     * Get a restaurant client by its ID
     */
    public function getById(RestaurantClientId $id): RestaurantClient;

    /**
     * Store a restaurant client
     */
    public function store(RestaurantClient $restaurantClient): void;

    /**
     * @param  array<RestaurantClient>  $restaurantClients
     * @return void
     */
    public function insertBulkClients(array $restaurantClients): void;

    /**
     * @param  array<RestaurantClient>  $restaurantClients
     * @return void
     */
    public function updateBulkClients(array $restaurantClients): void;

    /**
     * Find a restaurant client by app and app client ID
     *
     * @param  AppRestaurantClientId  $id
     * @return RestaurantClient|null
     */
    public function findByAppClientId(AppRestaurantClientId $id): ?RestaurantClient;

    /**
     * @param  RestaurantId  $restaurantId
     * @param  int|null  $limit
     * @param  int|null  $offset
     * @return array<RestaurantClient>
     */
    public function findByRestaurantId(RestaurantId $restaurantId, ?int $limit, ?int $offset): array;

    /**
     * @param  array<string>  $appClientIds
     * @param  AppEnum  $app
     * @return array<RestaurantClient>
     */
    public function getByAppRestaurantClientIds(array $appClientIds, AppEnum $app): array;
}
