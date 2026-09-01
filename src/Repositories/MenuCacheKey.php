<?php

declare(strict_types=1);

namespace Directsoft\LaravelMenu\Repositories;

use Directsoft\LaravelMenu\Repositories\Contracts\MenuCacheKeyInterface;

class MenuCacheKey implements MenuCacheKeyInterface
{
    use HasCacheKey;

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
}
