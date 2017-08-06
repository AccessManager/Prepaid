<?php

namespace AccessManager\Prepaid\Providers;


use Illuminate\Support\ServiceProvider;

class PrepaidServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom( __DIR__ . '/../Database/Migrations');
        $this->loadRoutesFrom( __DIR__ . '/../Routes/web.php');
        $this->loadViewsFrom( __DIR__ . '/../Views', 'Prepaid');
    }
}