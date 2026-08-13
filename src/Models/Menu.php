<?php

declare(strict_types=1);

namespace Directsoft\LaravelMenu\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    protected $fillable = [
        'title',
        'name',
        'position',
    ];

    public function casts(): array
    {
        return [
            //
        ];
    }

    public function menuItems(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'menu_id');
    }

    public function scopeByPosition(Builder $query, string $position): Builder
    {
        return $query->where('position', '=', $position);
    }
}
