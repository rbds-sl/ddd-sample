<?php

declare(strict_types=1);

namespace CoverManager\Core\Shared\Domain\ValueObjects;

final readonly class MarketingSubscription
{
    public function __construct(
        public ?int $optInAt = null,
        public ?int $optOutAt = null,
    ) {
    }

    public function isOptedIn(): bool
    {
        return $this->optInAt !== null && ($this->optOutAt === null || $this->optInAt > $this->optOutAt);
    }

    public function merge(?int $optInAt, ?int $optOutAt): self
    {
        $instance = new self(
            optInAt: $optInAt ?? $this->optInAt,
            optOutAt: $optOutAt ?? $this->optOutAt
        );
        return $instance;
    }


}
