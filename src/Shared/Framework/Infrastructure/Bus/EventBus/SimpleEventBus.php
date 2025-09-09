<?php

declare(strict_types=1);

namespace CoverManager\Shared\Framework\Infrastructure\Bus\EventBus;

use App\Models\User;
use CoverManager\Shared\Framework\Domain\Events\DomainEvent;
use Illuminate\Support\Facades\Auth;
use Throwable;

final class SimpleEventBus implements EventBusInterface
{
    private static int $lastEventId = 0;

    /**
     * @param  DomainEvent[]  $events
     *
     * @throws Throwable
     */
    public function publishEvents(array $events): void
    {
        foreach ($events as $event) {

            $eventModel = EventModelAR::create($event);
            if ($eventModel->userId === null) {
                /** @var User|null $user */
                $user = Auth::user();
                $event->userId = $user->id ?? null;
                $eventModel->userId = $event->userId;
            }
            if ($event->transient === false) {
                if ($eventModel->initiatorId === null && self::$lastEventId !== 0) {
                    $eventModel->initiatorId = (string) self::$lastEventId;
                }
                $eventModel->saveOrFail();
                $event->eventId = $eventModel->id;
                self::$lastEventId = $eventModel->id;
            }
            event($event);
        }
    }
}
