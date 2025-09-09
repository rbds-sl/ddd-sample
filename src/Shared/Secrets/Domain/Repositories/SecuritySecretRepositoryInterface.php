<?php

declare(strict_types=1);

namespace CoverManager\Shared\Secrets\Domain\Repositories;

use CoverManager\Shared\Secrets\Domain\Entities\SecuritySecret;
use CoverManager\Shared\Secrets\Domain\Enums\SecuritySecretTypeEnum;

interface SecuritySecretRepositoryInterface
{
    public function getSecretByTypeAndRestaurantId(
        SecuritySecretTypeEnum $type,
        ?string $environment = SecuritySecret::DEFAULT_ENVIRONMENT
    ): SecuritySecret;
}
