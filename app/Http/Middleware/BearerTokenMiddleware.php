<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class BearerTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Get the API token from the configuration
        $validToken = config('auth.api_token');

        // If no token is configured, deny all requests
        if (!$validToken) {
            return response()->json(['error' => 'API token not configured'], SymfonyResponse::HTTP_UNAUTHORIZED);
        }

        // Get the bearer token from the request
        $bearerToken = $request->bearerToken();

        // Check if the token is valid
        if (!$bearerToken || $bearerToken !== $validToken) {
            return response()->json(['error' => 'Unauthorized'], SymfonyResponse::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
