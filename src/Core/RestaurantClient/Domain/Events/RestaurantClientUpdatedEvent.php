<?php

declare(strict_types=1);

namespace CoverManager\Core\RestaurantClient\Domain\Events;

use CoverManager\Core\RestaurantClient\Domain\Entities\RestaurantClient;
use CoverManager\Shared\Framework\Domain\Events\DomainEvent;
use CoverManager\Shared\Framework\Helpers\MixedHelper;
use JsonSerializable;

final class RestaurantClientUpdatedEvent extends DomainEvent implements JsonSerializable
{
    public const string NAME = 'covermanager.crm.restaurantclient.restaurantClientUpdatedEvent';

    public RestaurantClient $origRestaurantClient;
    public RestaurantClient $modifiedRestaurantClient;

    public static function create(RestaurantClient $origRestaurantClient, RestaurantClient $modifiedRestaurantClient): self
    {
        $instance = new self(MixedHelper::getString($origRestaurantClient->id->getValue()));
        $instance->origRestaurantClient = $origRestaurantClient;
        $instance->modifiedRestaurantClient = $modifiedRestaurantClient;

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
                'origRestaurantClientData' => $this->origRestaurantClient,
                'newRestaurantClientData'  => $this->modifiedRestaurantClient,
            ],
        ];
    }
}
