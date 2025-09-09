<?php

declare(strict_types=1);

namespace CoverManager\Shared\Secrets\Application\Queries\GetSecret;

use CoverManager\Shared\Framework\Infrastructure\Bus\QueryBus\QueryInterface;
use CoverManager\Shared\Secrets\Domain\Entities\SecuritySecret;
use CoverManager\Shared\Secrets\Domain\Enums\SecuritySecretTypeEnum;

/**
 * @see GetSecuritySecretHandler
 * @implements QueryInterface<SecuritySecretDto>
 */
final readonly class GetSecuritySecretQuery implements QueryInterface
{
    public function __construct(
        public SecuritySecretTypeEnum $type,
        public ?string $environment = SecuritySecret::DEFAULT_ENVIRONMENT,
    ) {
    }
}

{
}
