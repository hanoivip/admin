<?php

namespace Hanoivip\Admin\Services;

use Hanoivip\Admin\UserRole;
use Hanoivip\Admin\ViewObjects\UserRoleVO;

class AdminService
{
    public function addRole($uid, $displayName, $roleName)
    {
        $roleRc = UserRole::where('user_id', $uid)->get();
        if ($roleRc->isEmpty())
        {
            $roleRc = new UserRole();
            $roleRc->user_id = $uid;
            $roleRc->display_name = $displayName;
            $roleRc->role = $roleRc;
        }
        else
        {
            $roleRc = $roleRc->first();
            $roleRc->display_name = $displayName;
            $roleRc->role = $roleRc->role . ',' . $roleName;
        }
        $roleName->save();
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