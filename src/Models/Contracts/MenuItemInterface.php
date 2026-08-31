<?php

declare(strict_types=1);

namespace Directsoft\LaravelMenu\Models\Contracts;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

interface MenuItemInterface
{
    public function menu(): BelongsTo;

    public function parent(): BelongsTo;

    public function children(): HasMany;
}
