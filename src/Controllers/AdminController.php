<?php

namespace Hanoivip\Admin\Controllers;

use Hanoivip\Admin\Services\PassportClient;
use Illuminate\Support\Facades\Log;
use Exception;
use Hanoivip\Admin\Requests\AddBalance;
use Hanoivip\Admin\Requests\AddServer;
use Hanoivip\Admin\Requests\AdminRequest;
use Hanoivip\Admin\Requests\RemoveServer;
use Hanoivip\PaymentClient\BalanceUtil;
use Hanoivip\Game\Server;
use Hanoivip\Game\Services\ServerService;

class AdminController extends Controller
{
    protected $passport;
    
    protected $balances;
    
    protected $servers;
    
    public function __construct(
        PassportClient $passport, 
        BalanceUtil $balances,
        ServerService $servers)
    {
        $this->passport = $passport;
        $this->balances = $balances;
        $this->servers = $servers;
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
            //Log::debug('Passport fetch user info:' . print_r($info, true));
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
    
    public function balanceInfo(AdminRequest $request)
    {
        $tid = $request->input('tid');
        $message = '';
        $error_message = '';
        try 
        {
            $info = $this->balances->getInfo($tid);
            return view('hanoivip::admin.balance-info', 
                ['tid' => $tid, 'balances' => $info]);
        }
        catch (Exception $ex)
        {
            Log::error('Admin get user balance info exception: ' . $ex->getMessage());
            $error_message = __('admin.user.balance-info.exception');
        }
        return view('hanoivip::admin.process-result',
            ['tid' => $tid, 'message' => $message, 'error_message' => $error_message]);
    }
    
    public function addBalance(AddBalance $request)
    {
        $tid = $request->input('tid');
        $balance = $request->input('balance');
        $reason = $request->input('reason');
        $message = '';
        $error_message = '';
        try 
        {
            if ($this->balances->add($tid, $balance, $reason))
                $message = __('admin.user.add-balance.sucess');
            else
                $error_message = __('admin.user.add-balance.fail');
        }
        catch (Exception $ex)
        {
            Log::error('Admin add balance exception: ' . $ex->getMessage());
            $error_message = __('admin.user.add-balance.exception');
        }
        return view('hanoivip::admin.process-result',
            ['tid' => $tid, 'message' => $message, 'error_message' => $error_message]);
    }
    
    public function balanceHistory(AdminRequest $request)
    {
        $tid = $request->input('tid');
    }
    
    public function serverInfo()
    {
        $all = $this->servers->getAll();
        return view('hanoivip::admin.server-info', ['servers' => $all]);
    }
    
    public function addServer(AddServer $request)
    {
        $message = '';
        $error_message = '';
        try 
        {
            $params = $request->all();
            //unset($params['_token']);
            $this->servers->addNew($params);
        }
        catch (Exception $ex)
        {
            Log::error('Admin add server exception: ' . $ex->getMessage());
            $error_message = __('admin.user.add-server.exception');
        }
        return view('hanoivip::admin.process-result',
            ['message' => $message, 'error_message' => $error_message]);
    }
    
    public function removeServer(RemoveServer $request)
    {
        $ident = $request->input('ident');
        $message = '';
        $error_message = '';
        try
        {
            $this->servers->removeByIdent($ident);
            $message = __('admin.user.remove-server.success');
        }
        catch (Exception $ex)
        {
            Log::error('Admin remove server exception: ' . $ex->getMessage());
            $error_message = __('admin.user.remove-server.exception');
        }
        return view('hanoivip::admin.process-result',
            ['message' => $message, 'error_message' => $error_message]);
    }
}