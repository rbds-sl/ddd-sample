<?php

declare(strict_types=1);

namespace Apps\Api\Internal;

use Apps\Api\Internal\Queue\QueueInfoAction;
use Illuminate\Http\JsonResponse;

final readonly class InternalController
{
    public function queueInfo(QueueInfoAction $action): JsonResponse
    {
        return new JsonResponse($action());

    }
}
