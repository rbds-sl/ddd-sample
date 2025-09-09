<?php

declare(strict_types=1);

namespace App\Providers;

use CoverManager\Core\Group\Domain\Events\GroupCreatedEvent;
use CoverManager\Core\Group\Domain\Events\GroupUpdatedEvent;
use CoverManager\Core\GroupClient\Application\ProcessManagers\UpdateOnClientUpdated\MatchOnRestaurantClientUpdatedHandler;
use CoverManager\Core\GroupClient\Application\ProcessManagers\UpdateProjectionOnCreateOrUpdated\UpdateProjectionOnCreateOrUpdateHandler;
use CoverManager\Core\GroupClient\Domain\Events\GroupClientCreatedEvent;
use CoverManager\Core\GroupClient\Domain\Events\GroupClientUpdatedEvent;
use CoverManager\Core\Restaurant\Domain\Events\RestaurantCreatedEvent;
use CoverManager\Core\Restaurant\Domain\Events\RestaurantUpdatedEvent;
use CoverManager\Core\RestaurantClient\Domain\Events\RestaurantClientCreatedEvent;
use CoverManager\Core\RestaurantClient\Domain\Events\RestaurantClientUpdatedEvent;
use CoverManager\Shared\Framework\Infrastructure\Queue\TrackJobCompletion;
use CoverManager\Shared\Framework\Infrastructure\Queue\TrackJobFailed;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Queue\Events\JobProcessed;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        RestaurantClientCreatedEvent::class => [
            MatchOnRestaurantClientUpdatedHandler::class,
        ],
        RestaurantClientUpdatedEvent::class => [
            MatchOnRestaurantClientUpdatedHandler::class,
        ],
        GroupClientCreatedEvent::class => [
            UpdateProjectionOnCreateOrUpdateHandler::class
        ],
        GroupClientUpdatedEvent::class => [
            UpdateProjectionOnCreateOrUpdateHandler::class
        ],
        RestaurantCreatedEvent::class => [
            // No handlers yet
        ],
        RestaurantUpdatedEvent::class => [
            // No handlers yet
        ],
        GroupCreatedEvent::class => [
            // No handlers yet
        ],
        GroupUpdatedEvent::class => [
            // No handlers yet
        ],
        JobProcessed::class => [
            TrackJobCompletion::class
        ],
        JobFailed::class=>[
            TrackJobFailed::class
        ]
    ];

}
