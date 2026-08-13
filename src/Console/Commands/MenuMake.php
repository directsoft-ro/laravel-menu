<?php

declare(strict_types=1);

namespace Directsoft\LaravelMenu\Console\Commands;

use Directsoft\LaravelMenu\Data\CreateMenuData;
use Directsoft\LaravelMenu\Repositories\Contracts\MenuRepositoryInterface;
use Directsoft\LaravelMenu\Services\Contracts\MenuServiceInterface;
use Illuminate\Console\Command;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Psr\Log\LoggerInterface;
use Throwable;

final class MenuMake extends Command
{
    /**
     * The command signature.
     */
    protected $signature = 'menu:make';

    /**
     * The command description.
     */
    protected $description = 'Make a menu';

    public function __construct(
        public readonly MenuRepositoryInterface $menuRepository,
        public readonly MenuServiceInterface $menuService,
        public readonly LoggerInterface $logService,
        public readonly ValidationFactory $validator,
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $title = $this->ask(__('Menu title'));
        $name = $this->ask(__('Menu name'));
        $position = $this->ask(__('Menu position'));

        $data = [
            'title' => $title,
            'name' => $name,
            'position' => $position,
        ];

        $validator = $this->validator->make($data, [
            'title' => ['required', 'max:250'],
            'name' => ['required', 'max:250'],
            'position' => ['nullable', 'max:250'],
        ]);

        if ($validator->fails()) {
            $this->error($validator->errors()->first());

            return self::FAILURE;
        }

        try {
            $menuData = CreateMenuData::from($data);
            $this->menuService->create($menuData);

            $this->info(__('Menu created'));

            return self::SUCCESS;
        } catch (Throwable $th) {
            $this->logService->error($th);

            $this->error($th->getMessage());

            return self::FAILURE;
        }
    }
}
