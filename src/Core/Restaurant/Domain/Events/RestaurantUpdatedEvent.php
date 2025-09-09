<?php

declare(strict_types=1);

namespace CoverManager\Core\Restaurant\Domain\Events;

use CoverManager\Core\Restaurant\Domain\Entities\Restaurant;
use CoverManager\Shared\Framework\Domain\Events\DomainEvent;
use CoverManager\Shared\Framework\Helpers\MixedHelper;
use JsonSerializable;

final class RestaurantUpdatedEvent extends DomainEvent implements JsonSerializable
{
    public const string NAME = 'covermanager.crm.restaurant.restaurantUpdatedEvent';

    private Restaurant $origRestaurant;
    private Restaurant $modifiedRestaurant;

    public static function create(Restaurant $origRestaurant, Restaurant $modifiedRestaurant): self
    {
        $instance = new self(MixedHelper::getString($origRestaurant->id->getValue()));
        $instance->origRestaurant = $origRestaurant;
        $instance->modifiedRestaurant = $modifiedRestaurant;

        return $instance;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @return array<mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'relatedId' => $this->relatedId,
            'name'      => $this->getName(),
            'payload'   => [
                'origRestaurantData' => $this->origRestaurant,
                'newRestaurantData'  => $this->modifiedRestaurant,
            ],
        ];
    }
}
