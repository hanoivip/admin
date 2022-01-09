<?php

namespace Hanoivip\Admin\Middlewares;

use Hanoivip\Admin\UserRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Closure;
use Illuminate\Support\Facades\App;

class CheckAdmin
{
    public function handle($request, Closure $next)
    {
        if (Auth::check())
        {
            if (App::environment('local')) 
            {
                return $next($request);
            }
            $uid = Auth::user()->getAuthIdentifier();
            $role = UserRole::find($uid);
            if (!empty($role) && strpos($role->role, 'admin') !== false)
                return $next($request);
            else
                Log::error('CheckAdmin detect non-authorized access from user:' . $uid);
        }
        return response('Unauthorized.', 401);
    }
}
