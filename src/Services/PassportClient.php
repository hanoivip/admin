<?php

namespace Hanoivip\Admin\Services;

use Illuminate\Support\Facades\Log;
use CurlHelper;
use Exception;
use Hanoivip\Admin\IPassportClient;

class PassportClient implements IPassportClient
{
    /**
     * Lấy các thông tin của người chơi từ passport.
     * 
     * @param number $uid
     * @return array personal, secure
     */
    public function fetchAllInfo($uid)
    {
        $url = config('admin.passport') . '/api/admin/user?uid=' . $uid;
        Log::debug('Passport fetch user info uri:' . $url);
        $response = CurlHelper::factory($url)->exec();
        if ($response['status'] == 404)
            return null;
        if ($response['status'] != 200)
            throw new Exception('Passport user info error');
        if ($response['data'] === false)
            throw new Exception('Passport info response is invalid (not json).');
        return $response['data'];
    }
    
    /**
     * Thiết lập mật khẩu mặc định
     * 
     * @param number $uid
     * @return boolean
     */
    public function resetPassword($uid)
    {
        $url = config('admin.passport') . '/api/admin/pass/reset?uid=' . $uid;
        $response = CurlHelper::factory($url)->exec();
        if ($response['content'] === 'ok')
            return true;
        Log::debug('Passport reset user pass fail. Err:' . $response['content']);
        return false;
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
        $url = config('admin.passport') . '/api/admin/token?uid=' . $uid;
        $response = CurlHelper::factory($url)->exec();
        if ($response['status'] != 200)
        {
            Log::debug('Passport generate user token error. Return content:' . $response['content']);
            return;
        }
        return $response['content'];
    }
}