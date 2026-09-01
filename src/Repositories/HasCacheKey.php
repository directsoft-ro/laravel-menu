<?php

declare(strict_types=1);

namespace Directsoft\LaravelMenu\Repositories;

use Illuminate\Support\Str;
use UnexpectedValueException;

trait HasCacheKey
{
    protected function cacheKey(string $key): string
    {
        $prefix = config('menu.cache_prefix');

        if (empty($prefix)) {
            throw new UnexpectedValueException(
                'The menu cache prefix is not defined.',
            );
        }

        return Str::of($prefix)
            ->append('-')
            ->append($key)
            ->lower()
            ->value();
    }
}
