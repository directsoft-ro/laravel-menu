<?php

declare(strict_types=1);

namespace Directsoft\LaravelMenu\Data;

class CreateMenuData extends Data
{
    public function __construct(
        public readonly string $title,
        public readonly string $name,
        public readonly ?string $position = null,
    )
    {
        //
    }
}
