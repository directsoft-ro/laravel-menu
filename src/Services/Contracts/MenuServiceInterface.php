<?php

declare(strict_types=1);

namespace Directsoft\LaravelMenu\Services\Contracts;

use Directsoft\LaravelMenu\Data\CreateMenuData;
use Directsoft\LaravelMenu\Data\CreateMenuItemData;
use Directsoft\LaravelMenu\Data\UpdateMenuData;
use Directsoft\LaravelMenu\Data\UpdateMenuItemData;
use Directsoft\LaravelMenu\Models\Menu;
use Directsoft\LaravelMenu\Models\Menu as MenuModel;
use Directsoft\LaravelMenu\Models\MenuItem;
use Throwable;

interface MenuServiceInterface
{
    /**
     * @throws Throwable
     */
    public function create(CreateMenuData $data): MenuModel;

    /**
     * @throws Throwable
     */
    public function update(MenuModel $menu, UpdateMenuData $data): bool;

    /**
     * @throws Throwable
     */
    public function delete(MenuModel $menu): bool;

    /**
     * @throws Throwable
     */
    public function addChildren(Menu $menu, CreateMenuItemData $data): MenuItem;

    /**
     * @throws Throwable
     */
    public function updateChildren(MenuItem $menuItem, UpdateMenuItemData $data): MenuItem;

    /**
     * @throws Throwable
     */
    public function deleteChildren(MenuItem $menuItem): MenuItem;
}
