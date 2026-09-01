<?php

declare(strict_types=1);

namespace Directsoft\LaravelMenu\Models\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

interface MenuInterface
{
    public function getId(): ?int;

    public function getTitle(): ?string;

    public function getName(): ?string;

    public function getPosition(): ?string;

    public function items(): HasMany;

    public function scopeByTitle(Builder $query, string $title): Builder;

    public function scopeByName(Builder $query, string $name): Builder;

    public function scopeByPosition(Builder $query, string $position): Builder;
}
