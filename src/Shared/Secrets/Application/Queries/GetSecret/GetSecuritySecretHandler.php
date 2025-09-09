<?php

declare(strict_types=1);

namespace CoverManager\Shared\Secrets\Application\Queries\GetSecret;

use CoverManager\Shared\Framework\Infrastructure\Bus\QueryBus\QueryHandlerInterface;
use CoverManager\Shared\Secrets\Domain\Repositories\SecuritySecretRepositoryInterface;

final readonly class GetSecuritySecretHandler implements QueryHandlerInterface
{
    public function __construct(
        private SecuritySecretRepositoryInterface $repository,
    ) {
    }

    public function __invoke(GetSecuritySecretQuery $query): SecuritySecretDto
    {
        $secret = $this->repository->getSecretByTypeAndRestaurantId(
            type: $query->type,
            environment: $query->environment
        );

        return new SecuritySecretDto(
            type: $secret->type,
            clientId: $secret->clientId,
            environment: $secret->environment,
            token: $secret->token,
            url: $secret->url,
            username: $secret->username,
            password: $secret->password,
            expiresAt: $secret->expiresAt
        );
    }
}
