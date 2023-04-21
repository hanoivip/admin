<?php

namespace Hanoivip\Admin;

use Hanoivip\Admin\Services\AdminService;
use Hanoivip\Admin\Services\ApiOperator;
use Illuminate\Support\ServiceProvider;
use Hanoivip\Admin\Services\DatabaseOperator;

class LibServiceProvider extends ServiceProvider
{
    public function boot()
    {        
        $this->publishes([
            __DIR__.'/../views' => resource_path('views/vendor/hanoivip'),
            __DIR__ . '/../config/admin.php' => config_path('admin.php'),
            __DIR__.'/../lang' => resource_path('lang/vendor/hanoivip'),
            __DIR__.'/../resources' =>public_path(),
        ]);
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadViewsFrom(__DIR__ . '/../views', 'hanoivip');
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        $this->loadTranslationsFrom( __DIR__.'/../lang', 'hanoivip.admin');
    }
    
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/admin.php', 'admin');
        $this->commands([
            \Hanoivip\Admin\Commands\AdminAdd::class,
            \Hanoivip\Admin\Commands\AdminSupporter::class,
        ]);
        $this->app->bind('admin', AdminService::class);
        $this->app->bind(IUserOperator::class, ApiOperator::class);
        /*
        $ops = config('admin.operator', 'api');
        if ($ops == 'database')
        {
            $this->app->bind(IUserOperator::class, DatabaseOperator::class);
        }
        else
        {
            $this->app->bind(IUserOperator::class, ApiOperator::class);
        }*/
    }
}
