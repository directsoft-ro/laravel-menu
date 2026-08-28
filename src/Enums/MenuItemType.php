<?php

declare(strict_types=1);

namespace Directsoft\LaravelMenu\Enums;

enum MenuItemType: string
{
    case INTERNAL = 'internal';
    case EXTERNAL = 'external';

    public function label(): string
    {
        return match ($this) {
            self::INTERNAL => __('Internal'),
            self::EXTERNAL => __('External'),
        };
    }
}
