<?php

declare(strict_types=1);

namespace CoverManager\Shared\Framework\Domain\Exceptions;

use DomainException;

class InvalidEnumException extends DomainException
{
    public function __construct(string $message = '')
    {
        parent::__construct($message);
    }
}
