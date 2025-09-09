<?php

declare(strict_types=1);

namespace App\Providers;

use CoverManager\Core\Restaurant\Domain\Repositories\RestaurantRepositoryInterface;
use CoverManager\Core\Restaurant\Infrastructure\Persistence\RestaurantRepository;
use CoverManager\Core\RestaurantClient\Domain\Repositories\RestaurantClientRepositoryInterface;
use CoverManager\Core\RestaurantClient\Infrastructure\Persistence\RestaurantClientRepository;
use CoverManager\Shared\Framework\Infrastructure\Bus\CommandBus\CommandBusInterface;
use CoverManager\Shared\Framework\Infrastructure\Bus\CommandBus\SimpleCommandBus;
use CoverManager\Shared\Framework\Infrastructure\Bus\EventBus\EventBusInterface;
use CoverManager\Shared\Framework\Infrastructure\Bus\EventBus\SimpleEventBus;
use CoverManager\Shared\Framework\Infrastructure\Bus\QueryBus\QueryBus;
use CoverManager\Shared\Framework\Infrastructure\Bus\QueryBus\QueryBusInterface;
use CoverManager\Shared\Secrets\Domain\Repositories\SecuritySecretRepositoryInterface;
use CoverManager\Shared\Secrets\Infrastructure\Repositories\SecuritySecretRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(QueryBusInterface::class, QueryBus::class);
        $this->app->bind(CommandBusInterface::class, SimpleCommandBus::class);
        $this->app->bind(EventBusInterface::class, SimpleEventBus::class);

        // Core repositories
        $this->app->bind(
            RestaurantClientRepositoryInterface::class,
            RestaurantClientRepository::class
        );
        $this->app->bind(
            RestaurantRepositoryInterface::class,
            RestaurantRepository::class
        );

        // Cover repositories
        $this->app->bind(
            SecuritySecretRepositoryInterface::class,
            SecuritySecretRepository::class
        );

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
