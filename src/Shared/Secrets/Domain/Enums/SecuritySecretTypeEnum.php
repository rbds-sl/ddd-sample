<?php

declare(strict_types=1);

namespace CoverManager\Shared\Secrets\Domain\Enums;

enum SecuritySecretTypeEnum: string
{
    case COVER_SERVICES_MONOLITH = 'coverServicesMonolith';
    case COVER_SERVICES_CRM = 'coverServicesCRM';
    case COVER_SERVICES_INTEGRATION = 'coverServicesIntegration';
    case COVER_SERVICES_NOTIFICATION = 'coverServicesNotification';


}
