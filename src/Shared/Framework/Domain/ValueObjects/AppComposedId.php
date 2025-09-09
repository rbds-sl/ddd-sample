<?php

declare(strict_types=1);

namespace CoverManager\Shared\Framework\Domain\ValueObjects;

use CoverManager\App\Domain\Enums\AppEnum;

abstract readonly class AppComposedId
{
    public function __construct(
        public AppEnum $app,
        public string $id
    ) {
    }
}
