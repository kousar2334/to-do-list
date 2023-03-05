<?php

namespace App\Providers;

use App\Interfaces\TodoListInterface;
use App\Repositories\TodoListRepository;
use Illuminate\Support\ServiceProvider;

class TodoListServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(TodoListInterface::class, TodoListRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
