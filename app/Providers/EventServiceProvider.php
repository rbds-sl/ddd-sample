<?php

declare(strict_types=1);

namespace App\Providers;

use CoverManager\Core\Restaurant\Domain\Events\RestaurantCreatedEvent;
use CoverManager\Core\Restaurant\Domain\Events\RestaurantUpdatedEvent;
use CoverManager\Shared\Framework\Infrastructure\Queue\TrackJobCompletion;
use CoverManager\Shared\Framework\Infrastructure\Queue\TrackJobFailed;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Queue\Events\JobProcessed;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        RestaurantCreatedEvent::class => [
            // No handlers yet
        ],
        RestaurantUpdatedEvent::class => [
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
