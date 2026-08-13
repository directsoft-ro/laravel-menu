<?php

declare(strict_types=1);

namespace Directsoft\LaravelMenu\Tests;

use Directsoft\LaravelMenu\MenuServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            MenuServiceProvider::class,
        ];
    }
}
