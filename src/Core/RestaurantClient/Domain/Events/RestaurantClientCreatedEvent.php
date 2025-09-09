<?php

declare(strict_types=1);

namespace CoverManager\Core\RestaurantClient\Domain\Events;

use CoverManager\Core\RestaurantClient\Domain\Entities\RestaurantClient;
use CoverManager\Core\RestaurantClient\Domain\ValueObjects\AppRestaurantClientId;
use CoverManager\Shared\Framework\Domain\Events\DomainEvent;
use CoverManager\Shared\Framework\Helpers\MixedHelper;
use JsonSerializable;

final class RestaurantClientCreatedEvent extends DomainEvent implements JsonSerializable
{
    public const string NAME = 'covermanager.crm.restaurantclient.restaurantClientCreatedEvent';

    public AppRestaurantClientId $appRestaurantClientId;

    public static function create(RestaurantClient $restaurantClient): self
    {
        $instance = new self(MixedHelper::getString($restaurantClient->id->getValue()));
        $instance->appRestaurantClientId = $restaurantClient->appRestaurantClientId;
        return $instance;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @return array<mixed>
     */
    public function jsonSerialize(): mixed
    {
        return [
            'relatedId' => $this->relatedId,
            'name'      => $this->getName(),
            'payload'   => [
                'appRestaurantClientId' => $this->appRestaurantClientId,
            ],
        ];
    }
}
