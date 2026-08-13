<?php

declare(strict_types=1);

namespace Directsoft\LaravelMenu\Console\Commands;

use Directsoft\LaravelMenu\Repositories\Contracts\MenuRepositoryInterface;
use Illuminate\Console\Command;

final class MenuList extends Command
{
    /**
     * The command signature.
     */
    protected $signature = 'menu:list';

    /**
     * The command description.
     */
    protected $description = 'Listing available menus';

    public function __construct(
        public readonly MenuRepositoryInterface $menuRepository,
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $menus = $this->menuRepository->getAll();

        $headers = [
            __('Title'),
            __('Name'),
            __('Position'),
            __('Items'),
            __('Created at'),
            __('Updated at'),
        ];

        $rows = [];

        foreach ($menus as $menu) {
            $rows[] = [
                $menu->title,
                $menu->name,
                $menu->position,
                $menu->menuItemsCount,
                $menu->created_at->toDateTimeString(),
                $menu->updated_at->toDateTimeString(),
            ];
        }

        $this->table($headers, $rows);

        return self::SUCCESS;
    }
}
