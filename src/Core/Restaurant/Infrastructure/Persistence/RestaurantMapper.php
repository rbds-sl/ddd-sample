<?php

declare(strict_types=1);

namespace CoverManager\Core\Restaurant\Infrastructure\Persistence;

use CoverManager\App\Domain\Enums\AppEnum;
use CoverManager\Core\Restaurant\Domain\Entities\Restaurant;
use CoverManager\Core\Restaurant\Domain\Enums\RestaurantStatusEnum;
use CoverManager\Core\Restaurant\Domain\ValueObjects\AppRestaurantId;
use CoverManager\Core\Restaurant\Domain\ValueObjects\RestaurantId;
use CoverManager\Shared\Framework\Helpers\MixedHelper;
use stdClass;

final class RestaurantMapper
{
    /**
     * Maps a RestaurantModel to a Restaurant entity
     */
    public function hydrate(RestaurantModel|stdClass $model): Restaurant
    {
        $appRestaurantId = new AppRestaurantId(
            app: AppEnum::from(MixedHelper::getString($model->app)),
            id: MixedHelper::getString($model->app_restaurant_id)
        );


        return new Restaurant(
            id: new RestaurantId(MixedHelper::getString($model->id)),
            appRestaurantId: $appRestaurantId,
            name: MixedHelper::getString($model->name),
            status: isset($model->status) ? RestaurantStatusEnum::from(MixedHelper::getString($model->status)) : RestaurantStatusEnum::getDefaultValue()
        )->hydrated();
    }

    /**
     * Maps a Restaurant entity to an array for database storage
     *
     * @return array<string, mixed>
     */
    public function extract(Restaurant $entity): array
    {
        return [
            'id' => $entity->id->value(),
            'app' => $entity->appRestaurantId->app->value,
            'app_restaurant_id' => $entity->appRestaurantId->id,
            'name' => $entity->name,
            'status' => $entity->status->value,
        ];
    }
}
