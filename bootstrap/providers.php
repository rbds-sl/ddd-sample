<?php

declare(strict_types=1);

use App\Providers\AppServiceProvider;
use App\Providers\EventServiceProvider;
use App\Providers\HorizonServiceProvider;
use App\Providers\RouteServiceProvider;

return [
    AppServiceProvider::class,
    EventServiceProvider::class,
    HorizonServiceProvider::class,
    RouteServiceProvider::class,
];
