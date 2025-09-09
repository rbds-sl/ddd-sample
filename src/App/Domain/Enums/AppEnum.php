<?php

declare(strict_types=1);

namespace CoverManager\App\Domain\Enums;

enum AppEnum: string
{
    case coverManager = 'cover-manager';
    case premiumGuest = 'premium-guest';
    case guestOnline = 'guest-online';
    case zenChef = 'zen-chef';

}
