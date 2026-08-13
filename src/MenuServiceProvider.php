<?php

declare(strict_types=1);

namespace Directsoft\LaravelMenu;

use Directsoft\LaravelMenu\Console\Commands\MenuCommand;
use Directsoft\LaravelMenu\Repositories\Contracts\MenuCacheKeyInterface;
use Directsoft\LaravelMenu\Repositories\Contracts\MenuRepositoryInterface;
use Directsoft\LaravelMenu\Repositories\MenuCacheKey;
use Directsoft\LaravelMenu\Repositories\MenuRepository;
use Directsoft\LaravelMenu\Services\Contracts\MenuServiceInterface;
use Directsoft\LaravelMenu\Services\MenuService;
use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/menu.php', 'menu');

        $this->app->bind(MenuCacheKeyInterface::class, MenuCacheKey::class);
        $this->app->bind(MenuRepositoryInterface::class, MenuRepository::class);

        $this->app->bind(MenuServiceInterface::class, MenuService::class);

        $this->app->singleton(Menu::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'menu');

        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->publishes([
            __DIR__.'/../config/laravel-menu.php' => config_path('menu.php'),
        ], ['menu', 'menu-config']);

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/menu'),
        ], ['menu', 'menu-views']);

        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/laravel-menu'),
        ], ['menu', 'menu-assets']);

        $this->publishesMigrations([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ], ['menu', 'menu-migrations']);

        $this->commands([
            MenuCommand::class,
        ]);
    }
}
