<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use CoverManager\Shared\Framework\Helpers\MixedHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use JsonException;

class QueryLogMiddleware
{
    public function __construct()
    {
    }

    /**
     * @throws JsonException
     */
    public function handle(Request $request, Closure $next)
    {
        // Enable query log
        DB::enableQueryLog();

        // Process the request and get the response
        $response = $next($request);

        // Get the query log and count the number of queries
        $queryLog = DB::getQueryLog();
        $queryCount = count($queryLog);

        // Add the query count to the response header
        $response->headers->set('X-Query-Count', MixedHelper::getString($queryCount));
        if ($request->get('debug')) {
            $this->debug($request, $queryLog, $response);
        }

        // Return the response
        return $response;
    }

    public function debug(Request $request, array $queryLog, mixed $response): void
    {
        $showTime = $request->get('debug') === 'time';
        $detail = $request->get('debug') === 'detail';
        $data = [];
        $result = '';
        foreach ($queryLog as $query) {
            if ($detail) {
                $data[$query['query']] = ($data[$query['query']] ?? '') . implode(',', $query['bindings']) . PHP_EOL;
            } else {
                $data[$query['query']] = ($data[$query['query']] ?? 0) + ($showTime ? $query['time'] : 1);
            }
        }
        ksort($data);
        foreach ($data as $query => $count) {
            $result .= $count . '  ' . $query . PHP_EOL;
        }
        $response->setContent($result);
    }

}
