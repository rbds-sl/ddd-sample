<?php

declare(strict_types=1);

namespace CoverManager\Shared\Framework\Infrastructure\Persistence;

use CoverManager\Shared\Framework\Helpers\MixedHelper;
use OpenSearch\Client;
use OpenSearch\ClientBuilder;

abstract class LaravelOpenSearchBaseRepository
{
    private static ?Client $client = null;

    public function sanitizeString(?string $string): ?string
    {
        if ($string === null) {
            return null;
        }
        return trim(str_replace(['"', "'", '\\', '/', '+', '*', '{', '}'], ' ', $string));
    }

    public function getOpenSearchConnection(): Client
    {
        if (self::$client) {
            return self::$client;
        }
        $uri = MixedHelper::getString(config('database.opensearch.host'));
        $user = MixedHelper::getString(config('database.opensearch.user'));
        $password = MixedHelper::getString(config('database.opensearch.password'));

        $client = (new ClientBuilder())
            ->setHosts([$uri])
            ->setBasicAuthentication($user, $password) // Use secure credential management in production
            ->setSSLVerification(false) // For testing only; use proper certificates in production
            ->build();
        self::$client = $client;
        return self::$client;

    }
}
