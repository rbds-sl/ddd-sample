<?php

declare(strict_types=1);

namespace CoverManager\Shared\Framework\Infrastructure\Bus\QueryBus;

use DomainException;

abstract class QueryBusException extends DomainException
{
}
