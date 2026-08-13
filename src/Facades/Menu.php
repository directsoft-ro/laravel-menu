<?php

declare(strict_types=1);

namespace Directsoft\LaravelMenu\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Directsoft\LaravelMenu\Menu
 */
final class Menu extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Directsoft\LaravelMenu\Menu::class;
    }
}
