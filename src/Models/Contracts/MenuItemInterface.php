<?php

declare(strict_types=1);

namespace Directsoft\LaravelMenu\Models\Contracts;

use Directsoft\LaravelMenu\Enums\MenuItemType;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

interface MenuItemInterface
{
    public function getId(): ?int;

    public function getTitle(): ?string;

    public function getTitleAsSlug(): ?string;

    public function getUrl(): ?string;

    public function getType(): ?MenuItemType;

    public function getClassName(): ?string;

    public function getSortOrder(): ?int;

    public function menu(): BelongsTo;

    public function parent(): BelongsTo;

    public function items(): HasMany;
}
