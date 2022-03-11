<?php

namespace App\Providers;

use App\Repositories\AdminPanel\EnvVariableRepository;
use App\Repositories\AdminPanel\Interfaces\IEnvVariableRepository;
use App\Services\EnvVariableService;
use App\Services\Interfaces\IEnvVariableService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerRepositories();
        $this->registerServices();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
    }

    private function registerRepositories()
    {
        $this->app->singleton(IEnvVariableRepository::class, EnvVariableRepository::class);
    }

    private function registerServices()
    {
        $this->app->singleton(IEnvVariableService::class, EnvVariableService::class);
    }
}
