<?php

declare(strict_types=1);

namespace CoverManager\Core\Restaurant\Infrastructure\Persistence;

use CoverManager\Core\Restaurant\Domain\Entities\Restaurant;
use CoverManager\Core\Restaurant\Domain\Repositories\RestaurantRepositoryInterface;
use CoverManager\Core\Restaurant\Domain\ValueObjects\AppRestaurantId;
use CoverManager\Core\Restaurant\Domain\ValueObjects\RestaurantId;
use CoverManager\Shared\Framework\Infrastructure\Persistence\EloquentRepository;
use Illuminate\Database\Query\Builder;
use RuntimeException;

final class RestaurantRepository extends EloquentRepository implements RestaurantRepositoryInterface
{
    public function __construct(
        private readonly RestaurantMapper $mapper
    ) {
    }

    public function getById(RestaurantId $id): Restaurant
    {
        /** @var RestaurantModel|null $model */
        $model = $this->getBaseQuery()
            ->where('id', $id->value())
            ->first();

        if (!$model) {
            throw new RuntimeException(sprintf('Restaurant with id %s not found', $id->value()));
        }

        return $this->mapper->hydrate($model);
    }


    public function getByAppId(AppRestaurantId $id): Restaurant
    {
        /** @var RestaurantModel|null $model */
        $model = $this->getBaseQuery()
            ->where('app', $id->app->value)
            ->where('app_restaurant_id', $id->id)
            ->first();

        if (!$model) {
            throw new RuntimeException(sprintf('Restaurant with id %s not found', $id->id));
        }

        return $this->mapper->hydrate($model);
    }

    public function findByAppRestaurantId(AppRestaurantId $id): ?Restaurant
    {
        /** @var RestaurantModel|null $model */
        $model = $this->getBaseQuery()
            ->where('app', $id->app->value)
            ->where('app_restaurant_id', $id->id)
            ->first();

        if (!$model) {
            return null;
        }

        return $this->mapper->hydrate($model);
    }


    public function store(Restaurant $restaurant): void
    {
        $data = $this->mapper->extract($restaurant);

        $this->upsert($restaurant, RestaurantModel::class, $data);
    }

    /**
     * @param  array<Restaurant>  $restaurants
     * @return void
     */
    public function insertBulkRestaurants(array $restaurants): void
    {
        $chunkSize = 1000;
        $chunks = array_chunk($restaurants, $chunkSize);
        foreach ($chunks as $chunk) {
            $data = [];
            foreach ($chunk as $restaurant) {
                $newData = $this->mapper->extract($restaurant);
                $data[] = $newData;
            }
            $columns = new RestaurantModel()->getFillable();
            foreach ($columns as $key => $column) {
                if ($column === 'id') {
                    unset($columns[$key]);
                }
                if ($column === 'created_at' || $column === 'updated_at') {
                    unset($columns[$key]);
                }
            }
            $this->upsertBulk(ARClassName: RestaurantModel::class, data: $data, keys: ['app', 'app_restaurant_id'], columns: $columns);
        }
    }

    /**
     * @return Builder
     */
    private function getBaseQuery(): Builder
    {
        return RestaurantModel::query()->toBase();
    }

}
