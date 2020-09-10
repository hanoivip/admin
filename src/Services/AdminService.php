<?php

namespace Hanoivip\Admin\Services;

use Hanoivip\Admin\UserRole;
use Hanoivip\Admin\ViewObjects\UserRoleVO;

class AdminService
{
    public function addRole($uid, $displayName, $role)
    {
        $role = UserRole::where('user_id', $uid)->get();
        if ($role->isEmpty())
        {
            $role = new UserRole();
            $role->user_id = $uid;
            $role->display_name = $displayName;
            $role->role = $role;
        }
        else
        {
            $role = $role->first();
            $role->role = $role->role . ',' . $role;
        }
        $role->save();
        return true;
    }
    
    /**
     * 
     * @return UserRoleVO[] List of GM
     */
    public function getSupporters()
    {
        $roles = UserRole::all();
        $list = [];
        foreach ($roles as $role)
        {
            if (strpos($role->role, 'supporter') != false)
            {
                $vo = new UserRoleVO();
                $vo->uid = $role->user_id;
                $vo->title = $role->display_name;
                $vo->role = 'supporter';
                $list[] = $vo;
            }
        }
        return $list;
    }
    
}