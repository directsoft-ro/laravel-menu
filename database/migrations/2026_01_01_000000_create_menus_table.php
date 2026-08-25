<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable($this->menuTableName())) {
            Schema::create($this->menuTableName(), function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('name')->unique();
                $table->string('position')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable($this->menuItemsTableName())) {
            Schema::create($this->menuItemsTableName(), function (Blueprint $table) {
                $table->id();
                $table->foreignId('menu_id')->constrained('menus')->cascadeOnDelete();
                $table->foreignId('parent_id')->nullable()->constrained('menu_items')->cascadeOnDelete();
                $table->string('title');
                $table->string('url');
                $table->unsignedInteger('sort_order')->default(0);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists($this->menuItemsTableName());
        Schema::dropIfExists($this->menuTableName());
    }

    protected function menuTableName(): string
    {
        return config('menu.menu_table_name');
    }

    protected function menuItemsTableName(): string
    {
        return config('menu.menu_items_table_name');
    }
};
