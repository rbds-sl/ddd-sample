<?php

declare(strict_types=1);

namespace CoverManager\Core\Restaurant\Domain\Entities;

use CoverManager\Core\Restaurant\Domain\Enums\RestaurantStatusEnum;
use CoverManager\Core\Restaurant\Domain\Events\RestaurantCreatedEvent;
use CoverManager\Core\Restaurant\Domain\Events\RestaurantUpdatedEvent;
use CoverManager\Core\Restaurant\Domain\ValueObjects\AppRestaurantId;
use CoverManager\Core\Restaurant\Domain\ValueObjects\RestaurantId;
use CoverManager\Shared\Framework\Domain\Entities\BaseEntity;

final class Restaurant extends BaseEntity
{
    public function __construct(
        public readonly RestaurantId $id,
        public readonly AppRestaurantId $appRestaurantId,
        public string $name,
        public RestaurantStatusEnum $status,
    ) {
    }

    public static function create(
        RestaurantId $restaurantId,
        AppRestaurantId $appRestaurantId,
        string $name,
        ?RestaurantStatusEnum $status = null,
    ): self {
        $instance = new self(
            id: $restaurantId,
            appRestaurantId: $appRestaurantId,
            name: trim($name),
            status: $status ?? RestaurantStatusEnum::getDefaultValue()
        );
        $instance->recordLast(RestaurantCreatedEvent::fromEntity($instance));
        return $instance;
    }

    public function update(
        string $name,
        ?RestaurantStatusEnum $status = null
    ): void {
        $this->name = trim($name);
        if ($status !== null) {
            $this->status = $status;
        }
        $this->recordLast(RestaurantUpdatedEvent::fromEntity($this));
    }

    public function activate(): void
    {
        $this->status = RestaurantStatusEnum::ACTIVE;
        $this->recordLast(RestaurantUpdatedEvent::fromEntity($this));
    }

    public function delete(): void
    {
        $this->status = RestaurantStatusEnum::DELETED;
        $this->recordLast(RestaurantUpdatedEvent::fromEntity($this));
    }

    public function deactivate(): void
    {
        $this->status = RestaurantStatusEnum::INACTIVE;
        $this->recordLast(RestaurantUpdatedEvent::fromEntity($this));
    }

}
