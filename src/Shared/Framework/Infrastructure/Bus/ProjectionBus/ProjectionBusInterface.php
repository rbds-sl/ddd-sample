<?php

declare(strict_types=1);

namespace CoverManager\Shared\Framework\Infrastructure\Bus\ProjectionBus;

use CoverManager\Shared\Framework\Application\Projections\ProjectionInterface;

interface ProjectionBusInterface
{
    public function project(ProjectionInterface $projection): mixed;
}
