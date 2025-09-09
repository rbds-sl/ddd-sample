<?php

declare(strict_types=1);

namespace CoverManager\Core\Restaurant\Domain\Repositories;

use CoverManager\Core\Restaurant\Domain\Entities\Restaurant;
use CoverManager\Core\Restaurant\Domain\ValueObjects\AppRestaurantId;
use CoverManager\Core\Restaurant\Domain\ValueObjects\RestaurantId;

interface RestaurantRepositoryInterface
{
    public function getById(RestaurantId $id): Restaurant;

    public function store(Restaurant $restaurant): void;

    /**
     * @param  Restaurant[]  $restaurants
     */
    public function insertBulkRestaurants(array $restaurants): void;

    public function getByAppId(AppRestaurantId $id): Restaurant;

    public function findByAppRestaurantId(AppRestaurantId $id): ?Restaurant;

}
