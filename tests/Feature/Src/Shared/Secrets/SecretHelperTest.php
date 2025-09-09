<?php
declare(strict_types=1);

namespace Tests\Feature\Src\Shared\Secrets;

use Tests\TestCase;

final class SecretHelperTest extends TestCase
{

    public function testCreateSecret(): void
    {
        $env=config('app.env');
        dd($env);
    }
}