<?php

declare(strict_types=1);

namespace Directsoft\LaravelMenu\Repositories;

use Directsoft\LaravelMenu\Models\Menu as MenuModel;
use Directsoft\LaravelMenu\Repositories\Contracts\MenuCacheKeyInterface;
use Directsoft\LaravelMenu\Repositories\Contracts\MenuRepositoryInterface;
use Illuminate\Cache\Repository as Cache;
use Illuminate\Database\Connection;
use Illuminate\Support\Collection;
use Psr\SimpleCache\InvalidArgumentException;
use Throwable;

class MenuRepository implements MenuRepositoryInterface
{
    public function __construct(
        public readonly MenuModel $menu,
        public readonly Cache $cache,
        public readonly MenuCacheKeyInterface $menuCacheKey,
        public readonly Connection $databaseConnection,
    ) {
        //
    }

    /**
     * @throws InvalidArgumentException
     */
    public function getAll(): Collection
    {
        $cacheKey = $this->menuCacheKey->getAll();

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        $menus = $this->menu->get();

        $this->cache->put($cacheKey, $menus);

        return $menus;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function findById(int $menuId): ?MenuModel
    {
        $cacheKey = $this->menuCacheKey->findById($menuId);

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        $menu = $this->menu->find($menuId);

        $this->cache->put($cacheKey, $menu);

        return $menu;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function findByPosition(string $position): ?MenuModel
    {
        $cacheKey = $this->menuCacheKey->findByPosition($position);

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        $menu = $this->menu->byPosition($position)->first();

        $this->cache->put($cacheKey, $menu);

        return $menu;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function getByPosition(string $position): Collection
    {
        $cacheKey = $this->menuCacheKey->getByPosition($position);

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        $menu = $this->menu->byPosition($position)->get();

        $this->cache->put($cacheKey, $menu);

        return $menu;
    }

    /**
     * @throws Throwable
     */
    public function create(array $data): MenuModel
    {
        return $this->databaseConnection->transaction(function () use ($data) {
            $menu = $this->menu->create($data);

            $this->clearCache($menu);

            return $menu;
        });
    }

    /**
     * @throws Throwable
     */
    public function update(MenuModel $menu, array $data): bool
    {
        return $this->databaseConnection->transaction(function () use ($menu, $data) {
            $menu->fill($data);

            if ($menu->isClean()) {
                return false;
            }

            $this->clearCache($menu);

            return $menu->save();
        });
    }

    /**
     * @throws Throwable
     */
    public function delete(MenuModel $menu): bool
    {
        return $this->databaseConnection->transaction(function () use ($menu) {
            $this->clearCache($menu);

            return $menu->delete();
        });
    }

    public function clearCache(?MenuModel $menu = null): void
    {
        $keys = [
            $this->menuCacheKey->getAll(),
        ];

        if ($menu) {
            $keys[] = $this->menuCacheKey->findById($menu->id);
            $keys[] = $this->menuCacheKey->findByPosition($menu->position);
            $keys[] = $this->menuCacheKey->getByPosition($menu->position);
        }

        foreach ($keys as $key) {
            $this->cache->forget($key);
        }
    }
}
