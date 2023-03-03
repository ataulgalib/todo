<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Collection;
use App\Services\Core\Mecros;
use App\Services\BaseService;
use App\Services\Core\BreadCrumInfoService;
use App\Services\Core\MecrosService;
use App\Services\Core\CacheService;
use App\Services\Core\LogManageService;
use App\Services\Core\SessionService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
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
        $this->app->singleton('BreadCrumInfoService', function ($app) {
            return new BreadCrumInfoService();
        });

        $this->app->singleton('CacheService', function ($app) {
            return new CacheService();
        });

        $this->app->singleton('LogManageService', function ($app) {
            return new LogManageService();
        });

        $this->app->singleton('SessionService', function ($app) {
            return new SessionService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Collection::mixin(new MecrosService, true);

    }
}
