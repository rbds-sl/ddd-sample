<?php

declare(strict_types=1);

namespace Apps\Api\Internal\Queue;

final readonly class QueueInfoRes
{
    public function __construct(
        public int $pending,
        public int $processing,
        public int $failed,
        public int $delayed,
        public int $workers,
        public int $processedToday
    ) {
    }

}
