<?php

declare(strict_types=1);

namespace CoverManager\Shared\Framework\Helpers;

use CoverManager\Shared\Framework\Infrastructure\Bus\QueryBus\QueryBusInterface;
use CoverManager\Shared\Secrets\Application\Queries\GetSecret\GetSecuritySecretQuery;
use CoverManager\Shared\Secrets\Application\Queries\GetSecret\SecuritySecretDto;
use CoverManager\Shared\Secrets\Domain\Entities\SecuritySecret;
use CoverManager\Shared\Secrets\Domain\Enums\SecuritySecretTypeEnum;

final class SecretHelper
{
    public static function getSecret(
        SecuritySecretTypeEnum $type,
        ?string                $environment = null,
    ): SecuritySecretDto {
        /** @var QueryBusInterface $queryBus */
        $queryBus = Container::getObjectInstance(QueryBusInterface::class);

        if ($environment === null) {
            $environment = MixedHelper::getString(config('app.env', SecuritySecret::DEFAULT_ENVIRONMENT));
        }

        return $queryBus->queryCached(new GetSecuritySecretQuery(
            type: $type,
            environment: $environment
        ), 60);
    }
}
