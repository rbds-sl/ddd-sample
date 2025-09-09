<?php

declare(strict_types=1);

namespace CoverManager\Core\Restaurant\Domain\Events;

use CoverManager\Core\Restaurant\Domain\Entities\Restaurant;
use CoverManager\Shared\Framework\Domain\Events\DomainEvent;
use CoverManager\Shared\Framework\Helpers\MixedHelper;

final class RestaurantCreatedEvent extends DomainEvent
{
    public const string NAME = 'covermanager.crm.restaurant.restaurantCreatedEvent';

    public static function create(Restaurant $restaurant): self
    {
        return new self(MixedHelper::getString($restaurant->id->getValue()));
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
