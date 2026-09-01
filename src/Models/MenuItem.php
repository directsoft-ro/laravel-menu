<?php

declare(strict_types=1);

namespace Directsoft\LaravelMenu\Models;

use Carbon\CarbonImmutable;
use Directsoft\LaravelMenu\Enums\MenuItemType;
use Directsoft\LaravelMenu\Models\Contracts\MenuItemInterface;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

/**
 * @property int $id
 * @property CarbonImmutable $created_at
 * @property CarbonImmutable $updated_at
 * @property int $menu_id
 * @property Menu $menu
 * @property string $title
 * @property string $type
 * @property string $class_name
 * @property int $sort_order
 */
#[Fillable(['menu_id', 'parent_id', 'title', 'url', 'type', 'class_name', 'sort_order'])]
class MenuItem extends Model implements MenuItemInterface, Sortable
{
    use SortableTrait;

    public array $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
    ];

    protected function casts(): array
    {
        return [
            'type' => MenuItemType::class,
        ];
    }

    public function getId(): ?int
    {
        return $this->getAttribute('id');
    }

    public function getTitle(): ?string
    {
        return $this->getAttribute('title');
    }

    public function getUrl(): ?string
    {
        return $this->getAttribute('url');
    }

    public function getType(): ?MenuItemType
    {
        return $this->getAttribute('type');
    }

    public function getClassName(): ?string
    {
        return $this->getAttribute('class_name');
    }

    public function getSortOrder(): ?int
    {
        return $this->getAttribute('sort_order');
    }

    /**
     * @return BelongsTo<Menu, $this>
     */
    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }

    /**
     * @return BelongsTo<MenuItem, $this>
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    /**
     * @return HasMany<MenuItem, $this>
     */
    public function children(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'parent_id');
    }
}
