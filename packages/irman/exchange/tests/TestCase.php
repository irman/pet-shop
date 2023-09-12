<?php

namespace Irman\Exchange\Tests;

use Irman\Exchange\Providers\ExchangeServiceProvider;
use Orchestra\Testbench\Concerns\WithWorkbench;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    use WithWorkbench;

    /**
     * {@inheritdoc}
     */
    protected function getPackageProviders($app): array
    {
        return [
            ExchangeServiceProvider::class,
        ];
    }
}
