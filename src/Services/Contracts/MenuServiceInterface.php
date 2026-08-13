<?php

declare(strict_types=1);

namespace Directsoft\LaravelMenu\Services\Contracts;

use Directsoft\LaravelMenu\Data\CreateMenuData;
use Directsoft\LaravelMenu\Data\UpdateMenuData;
use Directsoft\LaravelMenu\Models\Menu as MenuModel;
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
}
