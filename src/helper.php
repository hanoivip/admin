<?php 

use Hanoivip\Admin\UserRole;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

if (! function_exists('is_admin')) 
{
    function is_admin()
    {
        if (Auth::check())
        {
            if (App::environment('local'))
            {
                return true;
            }
            $uid = Auth::user()->getAuthIdentifier();
            $role = UserRole::find($uid);
            if (!empty($role) && strpos($role->role, 'admin') !== false)
            {
                return true;
            }
        }
        return false;
    }
}