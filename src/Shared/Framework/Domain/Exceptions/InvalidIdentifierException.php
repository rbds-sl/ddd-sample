<?php

declare(strict_types=1);

namespace CoverManager\Shared\Framework\Domain\Exceptions;

use CoverManager\Shared\Framework\Helpers\MixedHelper;
use DomainException;

class InvalidIdentifierException extends DomainException
{
    /**
     * @param  mixed  $value
     */
    public function __construct(string $class, $value)
    {
        parent::__construct($class . ' ' . MixedHelper::getStringOrNull($value));
    }
}
