<?php

declare(strict_types=1);

namespace CoverManager\Core\RestaurantClient\Infrastructure\Persistence;

use CoverManager\App\Domain\Enums\AppEnum;
use CoverManager\Core\Restaurant\Domain\ValueObjects\RestaurantId;
use CoverManager\Core\RestaurantClient\Domain\Entities\RestaurantClient;
use CoverManager\Core\RestaurantClient\Domain\Repositories\RestaurantClientRepositoryInterface;
use CoverManager\Core\RestaurantClient\Domain\ValueObjects\AppRestaurantClientId;
use CoverManager\Core\RestaurantClient\Domain\ValueObjects\RestaurantClientId;
use CoverManager\Shared\Framework\Infrastructure\Persistence\EloquentRepository;
use Exception;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use stdClass;

final class RestaurantClientRepository extends EloquentRepository implements RestaurantClientRepositoryInterface
{
    public function __construct(
        private readonly RestaurantClientMapper $mapper
    ) {
    }

    public function getById(RestaurantClientId $id): RestaurantClient
    {
        /** @var RestaurantClientModel|null $model */
        $model = $this->getBaseQuery()
            ->where('id', $id->getValue())
            ->first();

        if (!$model) {
            throw new Exception('Restaurant client not found ' . $id->getValue());
        }

        return $this->mapper->hydrate($model);
    }

    public function store(RestaurantClient $restaurantClient): void
    {
        $data = $this->mapper->extract($restaurantClient);

        $this->upsert($restaurantClient, RestaurantClientModel::class, $data);
    }


    /**
     * @param  array<RestaurantClient>  $restaurantClients
     * @return void
     */
    public function insertBulkClients(array $restaurantClients): void
    {
        $chunkSize = 1000;
        $chunks = array_chunk($restaurantClients, $chunkSize);
        foreach ($chunks as $chunk) {
            $data = [];
            foreach ($chunk as $restaurantClient) {
                $data[] = $this->mapper->extract($restaurantClient);
            }

            $this->insertBulk(ARClassName: RestaurantClientModel::class, data: $data);
        }
    }

    /**
     * @param  array<RestaurantClient>  $restaurantClients
     * @return void
     */
    public function updateBulkClients(array $restaurantClients): void
    {
        $chunkSize = 1000;
        $chunks = array_chunk($restaurantClients, $chunkSize);
        foreach ($chunks as $chunk) {
            $data = [];
            foreach ($chunk as $restaurantClient) {
                $data[] = array_merge($this->mapper->extract($restaurantClient), ['updated_at' => DB::raw('CURRENT_TIMESTAMP')]);
                //  $this->upsert($restaurantClient, RestaurantClientModel::class, $data);
            }
            $columns = new RestaurantClientModel()->getFillable();
            foreach ($columns as $key => $column) {
                if ($column === 'id') {
                    unset($columns[$key]);
                }
            }
            $columns[] = 'updated_at';

            $this->upsertBulk(ARClassName: RestaurantClientModel::class, data: $data, keys: ['app', 'app_client_id'], columns: $columns);
        }
    }

    /**
     * @return Builder
     */
    private function getBaseQuery(): Builder
    {
        return RestaurantClientModel::query()->toBase();
    }

    public function findByAppClientId(AppRestaurantClientId $id): ?RestaurantClient
    {
        /** @var RestaurantClientModel|null $model */
        $model = $this->getBaseQuery()
            ->where('app', $id->app->value)
            ->where('app_client_id', $id->id)
            ->first();

        if (!$model) {
            return null;
        }

        return $this->getById(new RestaurantClientId($model->id));
    }

    /**
     * @param  RestaurantId  $restaurantId
     * @param  int|null  $limit
     * @param  int|null  $offset
     * @return array<RestaurantClient>
     */
    public function findByRestaurantId(RestaurantId $restaurantId, ?int $limit, ?int $offset): array
    {
        $query = $this->getBaseQuery()
            ->where('restaurant_id', $restaurantId->getValue());

        if ($limit !== null) {
            $query->limit($limit);
        }

        if ($offset !== null) {
            $query->offset($offset);
        }

        /** @var RestaurantClientModel[] $models */
        $models = $query->orderBy('id')->get()->all();

        return array_map(
            fn (RestaurantClientModel|stdClass $model) => $this->mapper->hydrate($model),
            $models
        );
    }

    /**
     * @param  array<string>  $appClientIds
     * @param  AppEnum  $app
     * @return array<RestaurantClient>
     */
    public function getByAppRestaurantClientIds(array $appClientIds, AppEnum $app): array
    {
        /** @var array<RestaurantClientModel> $existing */
        $existing = $this->getBaseQuery()
            ->whereIn('app_client_id', $appClientIds)
            ->where('app', $app->value)
            ->get()->all();
        return array_map(
            fn (RestaurantClientModel|stdClass $model) => $this->mapper->hydrate($model),
            $existing
        );
    }
}
