<?php

namespace Irman\Notify\Tests;

use Irman\Notify\Providers\NotifyServiceProvider;
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
            NotifyServiceProvider::class,
        ];
    }
}
