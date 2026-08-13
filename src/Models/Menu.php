<?php

declare(strict_types=1);

namespace Directsoft\LaravelMenu\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property CarbonImmutable $created_at
 * @property CarbonImmutable $updated_at
 * @property string $title
 * @property string $name
 * @property string $position
 * @property ?int $menuItemsCount
 *
 * @method Builder<Menu> byPosition(string $position)
 */
class Menu extends Model
{
    protected $fillable = [
        'title',
        'name',
        'position',
    ];

    /**
     * @return HasMany<MenuItem, $this>
     */
    public function menuItems(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'menu_id');
    }

    /**
     * @param  Builder<Menu>  $query
     * @return Builder<Menu>
     */
    public function scopeByPosition(Builder $query, string $position): Builder
    {
        return $query->where('position', '=', $position);
    }
}
