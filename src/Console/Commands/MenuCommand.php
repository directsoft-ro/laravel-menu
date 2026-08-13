<?php

declare(strict_types=1);

namespace Directsoft\LaravelMenu\Console\Commands;

use Illuminate\Console\Command;

final class MenuCommand extends Command
{
    /**
     * The command signature.
     */
    protected $signature = 'menu:list';

    /**
     * The command description.
     */
    protected $description = 'Listing available menus';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->line('Menu placeholder command executed.');

        return self::SUCCESS;
    }
}
