<?php

declare(strict_types=1);

namespace App\Providers;

use CoverManager\Core\Booking\Domain\Repositories\BookingRepositoryInterface;
use CoverManager\Core\Booking\Infrastructure\Persistence\Repositories\MySqlBookingRepository;
use CoverManager\Core\Group\Domain\Repositories\GroupRepositoryInterface;
use CoverManager\Core\Group\Infrastructure\Persistence\Repositories\MySqlGroupRepository;
use CoverManager\Core\GroupClient\Domain\Repositories\GroupClientProjectionRepositoryInterface;
use CoverManager\Core\GroupClient\Domain\Repositories\GroupClientRepositoryInterface;
use CoverManager\Core\GroupClient\Infrastructure\Persistence\GroupClientRepository;
use CoverManager\Core\GroupClient\Infrastructure\Persistence\OpenSearchClientGroupRepository;
use CoverManager\Core\Restaurant\Domain\Repositories\RestaurantRepositoryInterface;
use CoverManager\Core\Restaurant\Infrastructure\Persistence\RestaurantRepository;
use CoverManager\Core\RestaurantClient\Domain\Repositories\RestaurantClientRepositoryInterface;
use CoverManager\Core\RestaurantClient\Infrastructure\Persistence\RestaurantClientRepository;
use CoverManager\Cover\Booking\Domain\Repositories\RemoteCoverBookingRepositoryInterface;
use CoverManager\Cover\Booking\Infrastructure\Remote\RemoteCoverBookingRepository;
use CoverManager\Cover\Client\Domain\Repositories\RemoteCoverClientRepositoryInterface;
use CoverManager\Cover\Client\Infrastructure\Remote\RemoteCoverClientRepository;
use CoverManager\Cover\Group\Domain\Repositories\RemoteCoverGroupRepositoryInterface;
use CoverManager\Cover\Group\Infrastructure\Remote\RemoteCoverGroupRepository;
use CoverManager\Cover\Restaurant\Domain\Repositories\RemoteCoverRestaurantRepositoryInterface;
use CoverManager\Cover\Restaurant\Infrastructure\Remote\RemoteCoverRestaurantRepository;
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
            GroupClientRepositoryInterface::class,
            GroupClientRepository::class
        );
        $this->app->bind(
            GroupRepositoryInterface::class,
            MySqlGroupRepository::class
        );
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
            RemoteCoverClientRepositoryInterface::class,
            RemoteCoverClientRepository::class
        );
        $this->app->bind(
            RemoteCoverGroupRepositoryInterface::class,
            RemoteCoverGroupRepository::class
        );
        $this->app->bind(
            RemoteCoverRestaurantRepositoryInterface::class,
            RemoteCoverRestaurantRepository::class
        );
        $this->app->bind(
            SecuritySecretRepositoryInterface::class,
            SecuritySecretRepository::class
        );

        $this->app->bind(
            GroupClientProjectionRepositoryInterface::class,
            OpenSearchClientGroupRepository::class
        );

        $this->app->bind(BookingRepositoryInterface::class,
            MySqlBookingRepository::class);

        $this->app->bind(RemoteCoverBookingRepositoryInterface::class,
            RemoteCoverBookingRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
