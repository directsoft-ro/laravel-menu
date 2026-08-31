<?php

declare(strict_types=1);

namespace Directsoft\LaravelMenu\Models;

use Carbon\CarbonImmutable;
use Directsoft\LaravelMenu\Models\Contracts\MenuInterface;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Spatie\Sluggable\Attributes\Sluggable;

/**
 * @property int $id
 * @property CarbonImmutable $created_at
 * @property CarbonImmutable $updated_at
 * @property string $title
 * @property string $name
 * @property string $position
 * @property Collection $menuItems
 * @property ?int $menuItemsCount
 *
 * @method Builder<Menu> byTitle(string $title)
 * @method Builder<Menu> byName(string $name)
 * @method Builder<Menu> byPosition(string $position)
 */
#[Fillable(['title', 'name', 'position'])]
#[Sluggable(from: 'title', to: 'name')]
class Menu extends Model implements MenuInterface
{
    /**
     * @return HasMany<MenuItem, $this>
     */
    public function items(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'menu_id');
    }

    /**
     * @param  Builder<Menu>  $query
     * @return Builder<Menu>
     */
    public function scopeByTitle(Builder $query, string $title): Builder
    {
        return $query->where('title', '=', $title);
    }

    /**
     * @param  Builder<Menu>  $query
     * @return Builder<Menu>
     */
    public function scopeByName(Builder $query, string $name): Builder
    {
        return $query->where('name', '=', $name);
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
