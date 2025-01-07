<?php

namespace Hanoivip\Admin\Services;

use Illuminate\Support\Facades\Log;
use Exception;
use Hanoivip\Admin\IUserOperator;

class DatabaseOperator implements IUserOperator
{
    /**
     * Lấy các thông tin của người chơi từ passport.
     * 
     * @param number $uid
     * @return array personal, secure
     */
    public function fetchAllInfo($uid)
    {
    }
    
    /**
     * Thiết lập mật khẩu mặc định
     * 
     * @param number $uid
     * @return boolean
     */
    public function resetPassword($uid)
    {
    }
    
    /**
     * Sinh token của người dùng
     * (không cần thông qua quá trình cho phép)
     * 
     * @param number $uid
     * @return string
     */
    public function generatePersonalToken($uid)
    {
    }
}