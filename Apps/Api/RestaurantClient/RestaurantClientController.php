<?php

declare(strict_types=1);

namespace Apps\Api\RestaurantClient;

use Apps\Api\RestaurantClient\Create\CreateClientAction;
use Apps\Api\RestaurantClient\Create\CreateClientRequest;
use Apps\Api\RestaurantClient\InsertBulk\InsertBulkAction;
use Apps\Api\RestaurantClient\InsertBulk\InsertBulkRequest;

final readonly class RestaurantClientController
{
    public function insertBulk(InsertBulkRequest $request, InsertBulkAction $action): void
    {
        $action($request->getClients());
    }

    public function create(CreateClientRequest $request, CreateClientAction $action): void
    {
        $action($request->getCommand());
    }

}
