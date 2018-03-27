<?php

namespace Hanoivip\Admin;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class LibServiceProvider extends ServiceProvider
{
    public function boot()
    {        
        $this->publishes([
            __DIR__.'/../views' => resource_path('views/vendor/hanoivip'),
        ]);
        
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadViewsFrom(__DIR__ . '/../views', 'hanoivip');
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        
        /* Multiple way of controlling authorization
         * 1. Gate
         * 2. Policy
         * 3. Route middleware
         * 
        Gate::define('is_admin', function () {
            Log::debug('Authorize check current player is admin');
            if (Auth::guard('token')->check())
            {
                $uid = Auth::guard('token')->user()['id'];
                $role = UserRole::find($uid);
                if (!empty($role))
                    return $role->role == 'admin';
            }
            return false;
        });
        
        Gate::define('is_moderator', function () {
            if (Auth::guard('token')->check())
            {
                $uid = Auth::guard('token')->user()['id'];
                $role = UserRole::find($uid);
                if (!empty($role))
                    return $role->role == 'admin';
            }
            return false;
        });*/
    }
}
