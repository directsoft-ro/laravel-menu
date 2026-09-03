<?php

declare(strict_types=1);

namespace Directsoft\LaravelMenu\Repositories\Contracts;

use Directsoft\LaravelMenu\Data\CreateMenuItemData;
use Directsoft\LaravelMenu\Data\UpdateMenuItemData;
use Directsoft\LaravelMenu\Models\Menu;
use Directsoft\LaravelMenu\Models\Menu as MenuModel;
use Directsoft\LaravelMenu\Models\MenuItem as MenuItemModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;
use Throwable;

interface MenuRepositoryInterface
{
    public function getPaginated(int $perPage = 25): LengthAwarePaginator;

    /**
     * @return Collection<int, MenuModel>
     *
     * @throws InvalidArgumentException
     */
    public function getAll(): Collection;

    /**
     * @throws InvalidArgumentException
     */
    public function findById(int $menuId): ?MenuModel;

    /**
     * @throws InvalidArgumentException
     */
    public function findByPosition(string $position): ?MenuModel;

    /**
     * @return Collection<int, MenuModel>
     *
     * @throws InvalidArgumentException
     */
    public function getByPosition(string $position): Collection;

    /**
     * @throws InvalidArgumentException
     */
    public function findItemById(int $menuId, int $menuItemId): ?MenuItemModel;

    /**
     * @param  array<string, mixed>  $data
     *
     * @throws Throwable
     */
    public function create(array $data): MenuModel;

    /**
     * @param  array<string, mixed>  $data
     *
     * @throws Throwable
     */
    public function update(MenuModel $menu, array $data): bool;

    /**
     * @throws Throwable
     */
    public function delete(MenuModel $menu): bool;

    /**
     * @throws Throwable
     */
    public function addItem(Menu $menu, CreateMenuItemData $data): MenuItemModel;

    /**
     * @throws Throwable
     */
    public function updateItem(MenuItemModel $menuItem, UpdateMenuItemData $data): bool;

    /**
     * @throws Throwable
     */
    public function deleteItem(MenuItemModel $menuItem): bool;

    public function clearCache(?MenuModel $menu = null): void;
}
