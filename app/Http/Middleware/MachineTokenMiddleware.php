<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use CoverManager\Shared\Framework\Helpers\SecretHelper;
use CoverManager\Shared\Secrets\Domain\Enums\SecuritySecretTypeEnum;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MachineTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('machine-token');

        $secret = SecretHelper::getSecret(SecuritySecretTypeEnum::COVER_SERVICES_CRM);
        if (!$token) {
            return response()->json(['message' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        $machineToken = $secret->token;

        if ($token !== $machineToken) {
            return response()->json(['message' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }

}