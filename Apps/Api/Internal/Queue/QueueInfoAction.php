<?php

declare(strict_types=1);

namespace Apps\Api\Internal\Queue;

use CoverManager\Shared\Framework\Helpers\MixedHelper;
use Illuminate\Support\Facades\Redis;

final readonly class QueueInfoAction
{
    /**
     * @return array<QueueInfoRes>
     */
    public function __invoke(): array
    {
        $queueNames = ['default'];
        $result = [];
        foreach ($queueNames as $queueName) {
            $today = date('Y-m-d');
            $processedToday = MixedHelper::getInt(Redis::connection()->get("queue_jobs_completed:{$queueName}:today:{$today}") ?? 0);
            $failedJobsCount = MixedHelper::getInt(Redis::connection()->get("queue_jobs_failed:{$queueName}:today:{$today}") ?? 0);
            $pending = Redis::connection()->llen("queues:{$queueName}");
            $processing = Redis::connection()->zcount("queues:{$queueName}:reserved", '-inf', '+inf');
            $delayed = Redis::connection()->zcount("queues:{$queueName}:delayed", '-inf', '+inf');
            $output = [];
            exec("ps aux | grep 'queue:work' | grep -v 'grep'", $output);
            $workers = count($output);

            $result[] = new QueueInfoRes(
                pending: $pending,
                processing: $processing,
                failed: $failedJobsCount,
                delayed: $delayed,
                workers: $workers,
                processedToday: $processedToday
            );
        }

        return $result;


    }

}
