<?php

declare(strict_types=1);

use Apps\Api\Internal\InternalController;
use Apps\Api\RestaurantClient\RestaurantClientController;
use Illuminate\Support\Facades\Route;


Route::get('/internal/queue/info', [InternalController::class, 'queueInfo']);
// Apply bearer token authentication to all API routes
Route::middleware('machine.token')->group(function () {
    // Group endpoints

    // RestaurantClient endpoints
    Route::post('/restaurant-client/insertBulk', [RestaurantClientController::class, 'insertBulk']);
    Route::post('/restaurant-client/create', [RestaurantClientController::class, 'create']);

});
