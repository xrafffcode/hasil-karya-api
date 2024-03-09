<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register() {


        $this->app->bind(\App\Interfaces\DriverRepositoryInterface::class, \App\Repositories\DriverRepository::class);
        $this->app->bind(\App\Interfaces\TruckRepositoryInterface::class, \App\Repositories\TruckRepository::class);
        $this->app->bind(\App\Interfaces\StationRepositoryInterface::class, \App\Repositories\StationRepository::class);
        $this->app->bind(\App\Interfaces\CheckerRepositoryInterface::class, \App\Repositories\CheckerRepository::class);
        $this->app->bind(\App\Interfaces\MaterialMovementRepositoryInterface::class, \App\Repositories\MaterialMovementRepository::class);
    $this->app->bind(\App\Interfaces\VendorRepositoryInterface::class, \App\Repositories\VendorRepository::class);
    }


    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
