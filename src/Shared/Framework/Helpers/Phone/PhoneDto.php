<?php

declare(strict_types=1);

namespace CoverManager\Shared\Framework\Helpers\Phone;

final class PhoneDto
{
    public function __construct(
        public readonly string $phone,
        public readonly int $prefix,
    ) {
    }
}
