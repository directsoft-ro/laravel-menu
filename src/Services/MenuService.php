<?php

declare(strict_types=1);

namespace Directsoft\LaravelMenu\Services;

use Directsoft\LaravelMenu\Data\CreateMenuData;
use Directsoft\LaravelMenu\Data\CreateMenuItemData;
use Directsoft\LaravelMenu\Data\UpdateMenuData;
use Directsoft\LaravelMenu\Data\UpdateMenuItemData;
use Directsoft\LaravelMenu\Events\MenuCreated;
use Directsoft\LaravelMenu\Events\MenuDeleted;
use Directsoft\LaravelMenu\Events\MenuUpdated;
use Directsoft\LaravelMenu\Models\Menu;
use Directsoft\LaravelMenu\Models\Menu as MenuModel;
use Directsoft\LaravelMenu\Models\MenuItem;
use Directsoft\LaravelMenu\Repositories\Contracts\MenuRepositoryInterface;
use Directsoft\LaravelMenu\Services\Contracts\MenuServiceInterface;
use Illuminate\Database\Connection;
use Throwable;

class MenuService implements MenuServiceInterface
{
    public function __construct(
        public readonly MenuRepositoryInterface $menuRepository,
        public readonly Connection              $databaseConnection,
    )
    {
        //
    }

    /**
     * @throws Throwable
     */
    public function create(CreateMenuData $data): MenuModel
    {
        return $this->databaseConnection->transaction(function () use ($data) {
            $menu = $this->menuRepository->create($data->toArray());

            event(new MenuCreated($menu->id));

            return $menu;
        });
    }

    /**
     * @throws Throwable
     */
    public function update(MenuModel $menu, UpdateMenuData $data): bool
    {
        return $this->databaseConnection->transaction(function () use ($menu, $data) {
            $updated = $this->menuRepository->update($menu, $data->toArray());

            if ($updated) {
                event(new MenuUpdated($menu->id));
            }

            return $updated;
        });
    }

    /**
     * @throws Throwable
     */
    public function delete(MenuModel $menu): bool
    {
        return $this->databaseConnection->transaction(function () use ($menu) {
            $menuId = $menu->id;
            $menuData = $menu->toArray();

            $deleted = $this->menuRepository->delete($menu);

            if ($deleted) {
                event(new MenuDeleted($menuId, $menuData));
            }

            return $deleted;
        });
    }

    /**
     * @throws Throwable
     */
    public function addChildren(Menu $menu, CreateMenuItemData $data): MenuItem
    {
        return $this->databaseConnection->transaction(function () use ($menu, $data) {
            $menuItem = $this->menuRepository->addChildren($menu, $data);

            event(new MenuUpdated($menu->id));

            return $menuItem;
        });
    }

    /**
     * @throws Throwable
     */
    public function updateChildren(MenuItem $menuItem, UpdateMenuItemData $data): MenuItem
    {
        return $this->databaseConnection->transaction(function () use ($menuItem, $data) {
            $updated = $this->menuRepository->updateChildren($menuItem, $data);

            if ($updated) {
                event(new MenuUpdated($menuItem->menu->id));
            }

            return $updated;
        });
    }

    /**
     * @throws Throwable
     */
    public function deleteChildren(MenuItem $menuItem): MenuItem
    {
        return $this->databaseConnection->transaction(function () use ($menuItem) {
            $deleted = $this->menuRepository->deleteChildren($menuItem);

            if ($deleted) {
                event(new MenuUpdated($menuItem->menu->id));
            }

            return $deleted;
        });
    }
}
