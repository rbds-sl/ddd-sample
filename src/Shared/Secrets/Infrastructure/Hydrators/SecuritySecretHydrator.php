<?php

declare(strict_types=1);

namespace CoverManager\Shared\Secrets\Infrastructure\Hydrators;

use CoverManager\Shared\Framework\Domain\Entities\BaseEntity;
use CoverManager\Shared\Secrets\Domain\Entities\SecuritySecret;
use CoverManager\Shared\Secrets\Domain\Enums\SecuritySecretTypeEnum;
use CoverManager\Shared\Secrets\Domain\ValueObjects\SecuritySecretId;
use CoverManager\Shared\Secrets\Infrastructure\Repositories\SecuritySecretTable;
use InvalidArgumentException;
use stdClass;

final class SecuritySecretHydrator
{
    /**
     * @param  SecuritySecretTable|stdClass  $data
     * @return SecuritySecret
     */
    public function hydrate(SecuritySecretTable|stdClass $data): BaseEntity
    {
        return new SecuritySecret(
            id: SecuritySecretId::create($data->id),
            restaurantId: $data->restaurant_id,
            type: SecuritySecretTypeEnum::from($data->type),
            clientId: $data->client_id,
            environment: $data->environment,
            token: $data->token,
            url: $data->url,
            username: $data->username,
            password: $data->password,
            createdAt: $data->created_at,
            expiresAt: $data->expires_at,
            valid: (bool)$data->valid
        );
    }

    /**
     * Extracts the data from a SecuritySecret entity into an array.
     *
     * @param BaseEntity $entity
     * @return array<string,mixed>
     * @throws InvalidArgumentException
     */
    public function extract(BaseEntity $entity): array
    {
        if (!$entity instanceof SecuritySecret) {
            throw new InvalidArgumentException('Entity must be an instance of SecuritySecret');
        }

        return [
            'id'            => $entity->id->getValue(),
            'restaurant_id' => $entity->restaurantId,
            'type'          => $entity->type->value,
            'client_id'     => $entity->clientId,
            'environment'   => $entity->environment,
            'token'         => $entity->token,
            'url'           => $entity->url,
            'username'      => $entity->username,
            'password'      => $entity->password,
            'created_at'    => $entity->createdAt,
            'expires_at'    => $entity->expiresAt,
            'valid'         => (int)$entity->valid
        ];
    }
}
