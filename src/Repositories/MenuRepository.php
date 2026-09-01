<?php

declare(strict_types=1);

namespace Directsoft\LaravelMenu\Repositories;

use Directsoft\LaravelMenu\Data\CreateMenuItemData;
use Directsoft\LaravelMenu\Data\UpdateMenuItemData;
use Directsoft\LaravelMenu\Models\Menu;
use Directsoft\LaravelMenu\Models\Menu as MenuModel;
use Directsoft\LaravelMenu\Models\MenuItem as MenuItemModel;
use Directsoft\LaravelMenu\Repositories\Contracts\MenuCacheKeyInterface;
use Directsoft\LaravelMenu\Repositories\Contracts\MenuRepositoryInterface;
use Illuminate\Cache\Repository as Cache;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Collection;
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
    public function getPaginated(int $perPage = 25): LengthAwarePaginator
    {
        return $this->menu->with('items')->paginate($perPage);
    }

    /**
     * @return Collection<int, MenuModel>
     *
     * @throws InvalidArgumentException
     */
    public function getAll(): Collection
    {
        $cacheKey = $this->menuCacheKey->getAll();

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        $menus = $this->menu->with('items')->get();

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

        $menu = $this->menu->with('items')->find($menuId);

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

        $menu = $this->menu->byPosition($position)->with('items')->first();

        $this->cache->put($cacheKey, $menu);

        return $menu;
    }

    /**
     * @return Collection<int, MenuModel>
     *
     * @throws InvalidArgumentException
     */
    public function getByPosition(string $position): Collection
    {
        $cacheKey = $this->menuCacheKey->getByPosition($position);

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        $menu = $this->menu->byPosition($position)->with('items')->get();

        $this->cache->put($cacheKey, $menu);

        return $menu;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function findItemById(int $menuId, int $menuItemId): ?MenuItemModel
    {
        $menu = $this->menu->with('items')->find($menuId);

        return $menu?->items->find($menuItemId);
    }

    /**
     * @param  array<string, mixed>  $data
     *
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
     * @param  array<string, mixed>  $data
     *
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

    /**
     * @throws Throwable
     */
    public function addItem(Menu $menu, CreateMenuItemData $data): MenuItemModel
    {
        return $this->databaseConnection->transaction(function () use ($menu, $data) {
            $menuItem = $menu->items()->create($data->toArray());
            $this->clearCache($menu);

            return $menuItem;
        });
    }

    /**
     * @throws Throwable
     */
    public function updateItem(MenuItemModel $menuItem, UpdateMenuItemData $data): bool
    {
        return $this->databaseConnection->transaction(function () use ($menuItem, $data) {
            $menuItem->fill($data->toArray());

            if ($menuItem->isClean()) {
                return false;
            }

            $this->clearCache($menuItem->menu);

            return $menuItem->save();
        });
    }

    /**
     * @throws Throwable
     */
    public function deleteItem(MenuItemModel $menuItem): bool
    {
        return $this->databaseConnection->transaction(function () use ($menuItem) {
            $this->clearCache($menuItem->menu);

            return $menuItem->delete();
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
