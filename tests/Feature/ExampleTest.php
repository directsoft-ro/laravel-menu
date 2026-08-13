<?php

declare(strict_types=1);

use Directsoft\LaravelMenu\Menu;

it('resolves the singleton', function () {
    expect(app(Menu::class))->toBeInstanceOf(Menu::class);
});

it('returns the same instance from the container', function () {
    expect(app(Menu::class))->toBe(app(Menu::class));
});

it('merges the package config', function () {
    expect(config('menu.menu_table_name'))->toBe('menus');
    expect(config('menu.menu_items_table_name'))->toBe('menu_items');
});

//it('loads the package views', function () {
//    expect(view()->exists('menu::placeholder'))->toBeTrue();
//});

it('registers the artisan command', function () {
    $this->artisan('menu:list')
        ->expectsOutputToContain('Title')
        ->assertSuccessful();
});
