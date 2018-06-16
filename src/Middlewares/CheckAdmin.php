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
        //if (Auth::guard('token')->check())
        if (Auth::check())
        {
            //$uid = Auth::guard('token')->user()['id'];
            $uid = Auth::user()->getAuthIdentifier();
            $role = UserRole::find($uid);
            if (!empty($role) && $role->role == 'admin')
                return $next($request);
            else
                Log::error('CheckAdmin detect non-authorized access from user:' . $uid);
        }
        return redirect()->route('home');
    }
}
