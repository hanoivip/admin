<?php

namespace Hanoivip\Admin\Middlewares;

use Hanoivip\Admin\UserRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Closure;

class CheckAdmin
{
    public function handle($request, Closure $next)
    {
        if (Auth::check())
        {
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
