<?php

declare(strict_types=1);

namespace Directsoft\LaravelMenu\Repositories\Contracts;

use Directsoft\LaravelMenu\Models\Menu as MenuModel;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;
use Throwable;

interface MenuRepositoryInterface
{
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
}
