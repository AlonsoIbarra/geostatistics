<?php

namespace App\Providers;

use App\Repositories\GeostatisticsRepository;
use App\Services\InegiApiService;
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
        $this->app->bind(GeostatisticsRepository::class, function ($app) {
            return new GeostatisticsRepository();
        });

        $this->app->bind(InegiApiService::class, function ($app) {
            return new InegiApiService( 'https://gaia.inegi.org.mx/wscatgeo/mgee/' );
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
