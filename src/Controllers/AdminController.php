<?php

namespace Hanoivip\Admin\Controllers;

use Hanoivip\Admin\Services\PassportClient;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Exception;
use Hanoivip\Admin\Requests\AdminRequest;

class AdminController extends Controller
{
    protected $passport;
    
    public function __construct(PassportClient $passport)
    {
        $this->passport = $passport;
    }
    
    public function findUser()
    {
        return view('hanoivip::admin.user-find');
    }
    
    public function detailUser(AdminRequest $request)
    {
        $tid = $request->input('tid');
        try
        {
            $info = $this->passport->fetchAllInfo($tid);
            if (empty($info))
                return view('hanoivip::admin.user-find', ['error_message' => __('admin.user.not-found')]);
            else
                return view('hanoivip::admin.user-detail',
                    ['tid' => $tid, 'personal' => $info['personal'], 'secure' => $info['secure']]);
        }
        catch (Exception $ex)
        {
            Log::error('Admin find user exception: ' . $ex->getMessage());
            return view('hanoivip::admin.user-find', ['error_message' => __('admin.user.find-exception')]);
        }
    }
    
    public function resetPass(AdminRequest $request)
    {
        $tid = $request->input('tid');
        $message = '';
        $error_message = '';
        try
        {
            if ($this->passport->resetPassword($tid))
                $message = __('admin.user.reset-pass.success');
            else 
                $error_message = __('admin.user.reset-pass.fail');
        }
        catch (Exception $ex)
        {
            Log::error('Admin reset user password exception: ' . $ex->getMessage());
            $error_message = __('admin.user.reset-pass.exception');
        }
        return view('hanoivip::admin.process-result', 
            ['tid' => $tid, 'message' => $message, 'error_message' => $error_message]);
    }
    
    public function logasUser(AdminRequest $request)
    {
        $tid = $request->input('tid');
        $message = '';
        $error_message = '';
        try 
        {
            $userToken = $this->passport->generatePersonalToken($tid);
            if (empty($userToken))
            {
                $error_message = __('admin.user.logas.fail');
            }
            else 
            {
                return redirect()->route('home', ['access_token' => $userToken]);
            }
        }
        catch (Exception $ex)
        {
            Log::error('Admin logas user exception: ' . $ex->getMessage());
            $error_message = __('admin.user.logas.exception');
        }
        return view('hanoivip::admin.process-result',
            ['tid' => $tid, 'message' => $message, 'error_message' => $error_message]);
    }
}