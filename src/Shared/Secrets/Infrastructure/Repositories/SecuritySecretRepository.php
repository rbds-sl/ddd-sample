<?php

declare(strict_types=1);

namespace CoverManager\Shared\Secrets\Infrastructure\Repositories;

use CoverManager\Shared\Framework\Infrastructure\Persistence\EloquentRepository;
use CoverManager\Shared\Secrets\Domain\Entities\SecuritySecret;
use CoverManager\Shared\Secrets\Domain\Enums\SecuritySecretTypeEnum;
use CoverManager\Shared\Secrets\Domain\Repositories\SecuritySecretRepositoryInterface;
use CoverManager\Shared\Secrets\Infrastructure\Hydrators\SecuritySecretHydrator;
use RuntimeException;

final class SecuritySecretRepository extends EloquentRepository implements SecuritySecretRepositoryInterface
{
    public function getSecretByTypeAndRestaurantId(
        SecuritySecretTypeEnum $type,
        ?string $environment = SecuritySecret::DEFAULT_ENVIRONMENT
    ): SecuritySecret {
        /** @var SecuritySecretTable|null $row */
        $row = SecuritySecretTable::query()->where('type', $type->value)
            ->where('valid', true)
            ->where('environment', $environment)
            ->toBase()->first();
        if (!$row) {
            throw new RuntimeException(sprintf('Secret of type %s not found for environment %s', $type->value, $environment));
        }
        return $this->getHydrator()->hydrate($row);
    }

    private function getHydrator(): SecuritySecretHydrator
    {
        return new SecuritySecretHydrator();
    }
}
