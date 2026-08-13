<?php

declare(strict_types=1);

namespace Directsoft\LaravelMenu\Repositories\Contracts;

interface MenuCacheKeyInterface
{
    public function getAll(): string;

    public function findById(int $menuId): string;

    public function findByPosition(string $position): string;

    public function getByPosition(string $position): string;
}
