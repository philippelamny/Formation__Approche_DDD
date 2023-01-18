<?php

namespace App\Providers;

use App\TodoList\Application\Contract\TodoListRepository;
use App\TodoList\Application\Gateway\AwsTodoListRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(TodoListRepository::class, function ($app) {
            return new AwsTodoListRepository();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
