<?php

declare(strict_types=1);

namespace Directsoft\LaravelMenu\Data;

class UpdateMenuItemData extends Data
{
    public function __construct(
        public readonly int $menu_id,
        public readonly string $title,
        public readonly ?string $url = null,
        public readonly ?int $parent_id = null,
        public readonly int $sort_order = 0,
    ) {
        //
    }
}
