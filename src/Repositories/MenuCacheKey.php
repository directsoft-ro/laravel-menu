<?php

declare(strict_types=1);

namespace Directsoft\LaravelMenu\Repositories;

use Directsoft\LaravelMenu\Repositories\Contracts\MenuCacheKeyInterface;
use Illuminate\Support\Str;
use UnexpectedValueException;

class MenuCacheKey implements MenuCacheKeyInterface
{
    public function getAll(): string
    {
        $methodName = __FUNCTION__;

        return $this->cacheKey($methodName);
    }

    public function findById(int $menuId): string
    {
        $methodName = __FUNCTION__;

        return $this->cacheKey("{$methodName}-{$menuId}");
    }

    public function findByPosition(string $position): string
    {
        $methodName = __FUNCTION__;

        return $this->cacheKey("{$methodName}-{$position}");
    }

    public function getByPosition(string $position): string
    {
        $methodName = __FUNCTION__;

        return $this->cacheKey("{$methodName}-{$position}");
    }

    protected function cacheKey(string $key): string
    {
        $prefix = config('menu.cache_prefix');

        if (empty($prefix)) {
            throw new UnexpectedValueException(
                'The menu cache prefix is not defined.',
            );
        }

        return Str::of($prefix)
            ->append('-')
            ->append($key)
            ->lower()
            ->value();
    }
}
