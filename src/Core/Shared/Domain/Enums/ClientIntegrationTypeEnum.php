<?php

declare(strict_types=1);

namespace CoverManager\Core\Shared\Domain\Enums;

enum ClientIntegrationTypeEnum: string
{
    case openTable = 'open-table';
    case THE_FORK = 'THE_FORK';
    case salesForce = 'sales-force';
    case LIGHTSPEED = 'LIGHTSPEED';
    case STRIPE = 'STRIPE';
    case FACEBOOK = 'FACEBOOK';
    case RESTAURANT_SYSTEM = 'RESTAURANT_SYSTEM';
}
