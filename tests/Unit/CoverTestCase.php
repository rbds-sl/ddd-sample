<?php

declare(strict_types=1);

namespace Tests\Unit;

use CoverManager\Shared\Framework\Infrastructure\Bus\CommandBus\CommandBusInterface;
use CoverManager\Shared\Framework\Infrastructure\Bus\QueryBus\QueryBusInterface;
use Illuminate\Foundation\Testing\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

abstract class CoverTestCase extends TestCase
{
    protected CommandBusInterface $commandBus;
    protected QueryBusInterface|MockObject $queryBus;


    protected function setUp(): void
    {
        parent::setUp();
        $this->commandBus = app(CommandBusInterface::class);
        $this->queryBus = $this->createMock(QueryBusInterface::class);
    }
}
