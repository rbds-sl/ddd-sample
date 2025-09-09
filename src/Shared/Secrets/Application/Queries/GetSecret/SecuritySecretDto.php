<?php

declare(strict_types=1);

namespace CoverManager\Shared\Secrets\Application\Queries\GetSecret;

use CoverManager\Shared\Secrets\Domain\Enums\SecuritySecretTypeEnum;

final class SecuritySecretDto
{
    public function __construct(
        public readonly SecuritySecretTypeEnum $type,
        public readonly ?string $clientId,
        public readonly ?string $environment,
        public readonly ?string $token,
        public readonly ?string $url,
        public readonly ?string $username,
        public readonly ?string $password,
        public readonly ?string $expiresAt,
    ) {
    }
}
