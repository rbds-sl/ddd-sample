<?php

declare(strict_types=1);

namespace CoverManager\Shared\Secrets\Infrastructure\Repositories;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $type
 * @property string|null $client_id
 * @property string|null $environment
 * @property string|null $token
 * @property string|null $url
 * @property string|null $username
 * @property string|null $password
 * @property int|null $restaurant_id
 * @property string $created_at
 * @property string $expires_at
 * @property int $valid
 */
final class SecuritySecretTable extends Model
{
    protected $table = 'security_secrets';
}
