<?php

declare(strict_types=1);

namespace CoverManager\Shared\Framework\Infrastructure\Bus\EventBus;

use CoverManager\Shared\Framework\Domain\Events\DomainEvent;
use CoverManager\Shared\Framework\Helpers\MixedHelper;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $eventName
 * @property string $relatedId
 * @property ?string $initiatorId
 * @property ?int $userId
 * @property int $occurredOn
 * @property string $data
 * @property ?string $stream
 */
final class EventModelAR extends Model
{
    protected $table = 'domain_event';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'eventName',
        'relatedId',
        'initiatorId',
        'userId',
        'occurredOn',
        'data',
        'stream',
    ];

    public static function create(DomainEvent $domainEvent): self
    {
        $properties = get_object_vars($domainEvent);
        $instance = new self();
        $instance->eventName = $domainEvent->getName();
        $instance->data = MixedHelper::safeJson($properties);
        $instance->relatedId = $domainEvent->relatedId;
        $instance->initiatorId = $domainEvent->initiator;
        $instance->userId = $domainEvent->userId;
        $instance->stream = $domainEvent->stream;
        $instance->occurredOn = $domainEvent->occurredOn;

        return $instance;
    }
}
