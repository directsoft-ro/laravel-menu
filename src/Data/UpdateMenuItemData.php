<?php

declare(strict_types=1);

namespace Directsoft\LaravelMenu\Data;

use Directsoft\LaravelMenu\Enums\MenuItemType;

class UpdateMenuItemData extends Data
{
    public function __construct(
        public readonly int $menu_id,
        public readonly string $title,
        public readonly MenuItemType $type,
        public readonly ?string $url = null,
        public readonly ?string $class_name = null,
        public readonly ?int $parent_id = null,
        public readonly int $sort_order = 0,
    ) {
        //
    }
}
