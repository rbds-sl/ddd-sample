<?php

declare(strict_types=1);

namespace CoverManager\Core\Shared\Domain\ValueObjects;

final readonly class ClientPreferences
{
    public function __construct(
        public ?string $foodPreferences = null,
        public ?string $foodRestrictions = null,
        public ?string $sittingPreferences = null,
        public ?string $waiterPreferences = null,
        public ?string $notes = null,
        public ?string $accessibility = null
    ) {

    }

    public function merge(
        ?string $foodPreferences,
        ?string $foodRestrictions,
        ?string $sittingPreferences,
        ?string $waiterPreferences,
        ?string $notes,
        ?string $accessibility
    ): ?self {
        $instance = new self(
            foodPreferences: $foodPreferences ?? $this->foodPreferences,
            foodRestrictions: $foodRestrictions ?? $this->foodRestrictions,
            sittingPreferences: $sittingPreferences ?? $this->sittingPreferences,
            waiterPreferences: $waiterPreferences ?? $this->waiterPreferences,
            notes: $notes ?? $this->notes,
            accessibility: $accessibility ?? $this->accessibility
        );
        if ($instance->isEmpty()) {
            return null;
        }
        return $instance;
    }

    private function isEmpty(): bool
    {
        return empty($this->foodPreferences) &&
            empty($this->foodRestrictions) &&
            empty($this->sittingPreferences) &&
            empty($this->waiterPreferences) &&
            empty($this->notes) &&
            empty($this->accessibility);
    }

}
