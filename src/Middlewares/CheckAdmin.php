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
        if (Auth::guard('token')->check())
        {
            $uid = Auth::guard('token')->user()['id'];
            $role = UserRole::find($uid);
            if (!empty($role) && $role->role == 'admin')
                return $next($request);
            else
                Log::error('CheckAdmin detect non-authorized access from user:' . $uid);
        }
        return redirect()->route('home');
    }
}
