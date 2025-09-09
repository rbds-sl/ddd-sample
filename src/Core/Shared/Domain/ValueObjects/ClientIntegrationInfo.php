<?php

declare(strict_types=1);

namespace CoverManager\Core\Shared\Domain\ValueObjects;

use CoverManager\Core\Shared\Domain\Enums\ClientIntegrationTypeEnum;

final readonly class ClientIntegrationInfo
{
    public function __construct(
        public ClientIntegrationTypeEnum $integration,
        public string $id,
    ) {
    }

}
