<?php

declare(strict_types=1);

namespace CoverManager\Shared\Framework\Domain\Events;

use CoverManager\Shared\Framework\Domain\Entities\BaseEntity;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;

/**
 * @template T
 */
class DomainEvent
{
    use Dispatchable;
    use InteractsWithSockets;

    public bool $transient = false;
    public ?int $eventId;
    public string $relatedId;
    public int $occurredOn;
    public ?int $userId;
    public ?string $initiator;
    public ?string $stream;

    /** @var array<string,mixed> */
    public array $data = [];

    final protected function __construct(string $relatedId, ?int $userId = null, ?string $initiator = null)
    {
        $this->relatedId = $relatedId;
        $this->userId = $userId;
        $this->occurredOn = time();
        $this->stream = null;
        $this->initiator = $initiator;
    }

    public function getName(): string
    {
        $fullName = static::class;
        $parts = explode('\\', $fullName);

        return end($parts);
    }

    public static function getStaticName(): string
    {
        return (new static(''))->getName();
    }

    /**
     * @param  array<string,mixed>  $data
     * @return DomainEvent|static
     */
    public static function hydrate(string $relatedId, ?int $userId, ?string $initiator, array $data): self
    {
        $event = new static($relatedId, $userId, $initiator);
        $event->data = $data;

        return $event;
    }

    /**
     * @param BaseEntity $entity
     * @return DomainEvent
     */
    public static function fromEntity(BaseEntity $entity): self
    {
        $event = new static((string) $entity->id->getValue());
        $event->data = $entity->serialize();

        return $event;
    }

    /**
     * @param BaseEntity $entity
     * @return DomainEvent
     */
    public static function fromEntityId(BaseEntity $entity): self
    {
        $event = new static((string) $entity->id->getValue());
        // if (property_exists($entity, 'userId')) {
        //     $event->data['userId'] = $entity->userId->getValue();
        // }
        return $event;
    }

    public function equals(DomainEvent $domainEvent): bool
    {
        return ($this->getName() === $domainEvent->getName()) && (
            json_encode($this) === json_encode($domainEvent)
        );
    }
}
