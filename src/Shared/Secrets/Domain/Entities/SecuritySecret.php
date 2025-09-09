<?php

declare(strict_types=1);

namespace CoverManager\Shared\Secrets\Domain\Entities;

use CoverManager\Shared\Framework\Domain\Entities\BaseEntity;
use CoverManager\Shared\Secrets\Domain\Enums\SecuritySecretTypeEnum;
use CoverManager\Shared\Secrets\Domain\ValueObjects\SecuritySecretId;

final class SecuritySecret extends BaseEntity
{
    public const string DEFAULT_ENVIRONMENT = 'production';

    public function __construct(
        public readonly SecuritySecretId $id,
        public ?int $restaurantId,
        public readonly SecuritySecretTypeEnum $type,
        public readonly ?string $clientId,
        public readonly ?string $environment,
        public readonly ?string $token,
        public readonly ?string $url,
        public readonly ?string $username,
        public readonly ?string $password,
        public readonly string $createdAt,
        public readonly ?string $expiresAt,
        public readonly bool $valid,
    ) {
    }
}
