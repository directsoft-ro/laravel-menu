<?php

declare(strict_types=1);

namespace Directsoft\LaravelMenu\Repositories\Contracts;

use Directsoft\LaravelMenu\Models\Menu as MenuModel;
use Illuminate\Support\Collection;

interface MenuRepositoryInterface
{
    public function getAll(): Collection;

    public function findById(int $menuId): ?MenuModel;

    public function findByPosition(string $position): ?MenuModel;

    public function getByPosition(string $position): Collection;

    public function create(array $data): MenuModel;

    public function update(MenuModel $menu, array $data): bool;

    public function delete(MenuModel $menu): bool;
}
