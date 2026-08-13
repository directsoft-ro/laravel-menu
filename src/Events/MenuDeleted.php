<?php

declare(strict_types=1);

namespace Directsoft\LaravelMenu\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

final class MenuDeleted
{
    use Dispatchable, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public readonly int $menuId,
        public readonly array $data = [],
    ) {
        //
    }
}
