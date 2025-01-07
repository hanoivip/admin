<?php

namespace Hanoivip\Admin\Controllers;

use Hanoivip\Admin\IUserOperator;
use Hanoivip\Admin\Requests\AddBalance;
use Hanoivip\Admin\Requests\AdminRequest;
use Hanoivip\Admin\Services\AdminService;
use Hanoivip\Events\Game\UserRecharge;
use Hanoivip\Events\Gate\UserTopup;
use Hanoivip\Payment\Facades\BalanceFacade;
use Hanoivip\Payment\Facades\BalanceRequest;
use Hanoivip\User\Facades\UserFacade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Exception;

class AdminController extends Controller
{
    protected $passport;
    
    protected $admin;
    
    public function __construct(
        IUserOperator $passport,
        AdminService $admin)
    {
        $this->passport = $passport;
        $this->admin = $admin;
    }
    
    public function findUser()
    {
        return view('hanoivip::admin.user-find');
    }
    // TODO: UserProvider?
    public function detailUser(AdminRequest $request)
    {
        $tid = $request->input('tid');
        try
        {
            $info = $this->passport->fetchAllInfo($tid);
            if (empty($info))
            {
                if (!is_numeric($tid))
                {
                    // retry with hash username
                    $hash = md5($tid);
                    $info = $this->passport->fetchAllInfo($hash);
                }
                
            }
            if (empty($info))
            {
                return view('hanoivip::admin.user-find', ['error_message' => __('hanoivip.admin::admin.user.not-found')]);
            }
            else
            {
                return view('hanoivip::admin.user-detail',
                    ['tid' => $info['id'], 'personal' => $info['personal'], 'secure' => $info['secure']]);
            }
        }
        catch (Exception $ex)
        {
            Log::error('Admin find user exception: ' . $ex->getMessage());
            return view('hanoivip::admin.user-find', ['error_message' => __('hanoivip.admin::admin.user.find-exception')]);
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
                $message = __('hanoivip.admin::admin.reset-pass.success');
            else 
                $error_message = __('hanoivip.admin::admin.reset-pass.fail');
        }
        catch (Exception $ex)
        {
            Log::error('Admin reset user password exception: ' . $ex->getMessage());
            $error_message = __('hanoivip.admin::admin.reset-pass.exception');
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
            $userId = Auth::user()->getAuthIdentifier();
            $targetUser = UserFacade::getUserCredentials($tid);
            if (empty($targetUser))
            {
                $error_message = __('hanoivip.admin::admin.logas.user-not-exists');
                return view('hanoivip::admin.process-result', ['error_message' => $error_message, 'tid' => $tid]);
            }
            else
            {
                $role = $this->admin->getRole($tid);
                if (!empty($role))
                {
                    return view('hanoivip::admin.process-result', ['error_message' => __('hanoivip.admin::admin.logas.user-is-mod'), 'tid' => $tid]);
                }
                $message = __('hanoivip.admin::admin.logas.success');
                //session()->flush();
                //Auth::logout();
                //Auth::login($targetUser, true);
                //$result = Auth::loginUsingId($tid);
                //$result = Auth::login($targetUser);
                //Log::debug(print_r($result, true));
                //Auth::onceUsingId($tid);??
                //session()->put('admin_user_id', $userId);
                session()->put('impersonate', $tid);
                //Cache::put('impersonate_' . $userId, $tid, Carbon::now()->addMinutes(10));
                return response()->redirectToRoute('home')->with(['message' => $message]);
            }
        }
        catch (Exception $ex)
        {
            Log::error('Admin logas user exception: ' . $ex->getMessage());
            return view('hanoivip::admin.process-result', ['error_message' => __('hanoivip.admin::admin.user.logas.exception'), 'tid' => $tid]);
        }
    }
    
    public function exitLogasUser(AdminRequest $request)
    {
        
    }
    
    public function logasUser1(AdminRequest $request)
    {
        $tid = $request->input('tid');
        $message = '';
        $error_message = '';
        try 
        {
            $userToken = $this->passport->generatePersonalToken($tid);
            if (empty($userToken))
            {
                $error_message = __('hanoivip.admin::admin.user.logas.fail');
            }
            else 
            {
                return redirect()->route('home', ['access_token' => $userToken]);
            }
        }
        catch (Exception $ex)
        {
            Log::error('Admin logas user exception: ' . $ex->getMessage());
            $error_message = __('hanoivip.admin::admin.user.logas.exception');
        }
        return view('hanoivip::admin.process-result',
            ['tid' => $tid, 'message' => $message, 'error_message' => $error_message]);
    }
    
    public function testActivity(AdminRequest $request)
    {
        $tid = $request->input('tid');
        return view('hanoivip::admin.activity-test', ['tid' => $tid]);
    }
    
    public function fakeTopup(AdminRequest $request)
    {
        $tid = $request->input('tid');
        $coin = $request->input('topup');
        event(new UserTopup($tid, 0, $coin, "Admin test event topup"));
        return view('hanoivip::admin.process-result',
            ['tid' => $tid, 'message' => __('event.test.topup.success')]);
    }
    
    public function fakeRecharge(AdminRequest $request)
    {
        $tid = $request->input('tid');
        $coin = $request->input('recharge');
        $svname = $request->input('svname');
        $role = $request->input('role');
        event(new UserRecharge($tid, 0, $coin, $svname, ['roleid' => $role]));
        return view('hanoivip::admin.process-result',
            ['tid' => $tid, 'message' => __('event.test.recharge.success')]);
    }
    
    public function balanceInfo(AdminRequest $request)
    {
        $tid = $request->input('tid');
        $message = '';
        $error_message = '';
        try 
        {
            $info = BalanceFacade::getInfo($tid);
            return view('hanoivip::admin.balance-info', 
                ['tid' => $tid, 'balances' => $info]);
        }
        catch (Exception $ex)
        {
            Log::error('Admin get user balance info exception: ' . $ex->getMessage());
            $error_message = __('hanoivip.admin::admin.user.balance-info.exception');
        }
        return view('hanoivip::admin.process-result',
            ['tid' => $tid, 'message' => $message, 'error_message' => $error_message]);
    }
    
    public function addBalance(AddBalance $request)
    {
        $userId = Auth::user()->getAuthIdentifier();
        $tid = $request->input('tid');
        $balance = $request->input('balance');
        $reason = $request->input('reason');
        $message = '';
        $error_message = '';
        try 
        {
            // check target user must be supporter
            $role = $this->admin->getRole($tid);
            if (empty($role))
            {
                Log::error("Admin $userId tried to add coin for non-supporter $tid");
                $error_message = __('hanoivip.admin::admin.balance.add.denied');
            }
            else if (BalanceRequest::request($userId, $tid, $reason, $balance))
                $message = __('hanoivip.admin::admin.balance.add.sucess');
            else
                $error_message = __('hanoivip.admin::admin.balance.add.fail');
        }
        catch (Exception $ex)
        {
            Log::error('Admin add balance exception: ' . $ex->getMessage());
            $error_message = __('hanoivip.admin::admin.balance.add.exception');
        }
        return view('hanoivip::admin.process-result',
            ['tid' => $tid, 'message' => $message, 'error_message' => $error_message]);
    }
    
    public function removeBalance(AddBalance $request)
    {
        $userId = Auth::user()->getAuthIdentifier();
        $tid = $request->input('tid');
        $balance = $request->input('balance');
        $reason = $request->input('reason');
        $message = '';
        $error_message = '';
        try
        {
            $role = $this->admin->getRole($tid);
            if (empty($role))
            {
                $error_message = __('hanoivip.admin::admin.balance.remove.denied');
            }
            else if (BalanceRequest::request($userId, $tid, $reason, -1 * $balance))
                $message = __('hanoivip.admin::admin.balance.remove.success');
            else
                $error_message = __('hanoivip.admin::admin.balance.remove.fail');
        }
        catch (Exception $ex)
        {
            Log::error('Admin add balance exception: ' . $ex->getMessage());
            $error_message = __('hanoivip.admin::admin.user.balance.remove.exception');
        }
        return view('hanoivip::admin.process-result',
            ['tid' => $tid, 'message' => $message, 'error_message' => $error_message]);
    }
    
    public function back(Request $request)
    {
        return back();
    }
    
    public function mods(Request $request)
    {
        $message = "";
        $errorMessage = "";
        if ($request->getMethod() == 'POST')
        {
            try
            {
                $username = $request->input('username');
                $user = UserFacade::getUserCredentials($username);
                if (empty($user))
                {
                    // try with hashed username
                    $user = UserFacade::getUserCredentials(md5($username));
                }
                if (empty($user))
                {
                    $errorMessage = "User not found";
                }
                else
                {
                    $result = $this->admin->addRole($user->id, "Mod", "mod");
                    if ($result)
                    {
                        $message = "Add mod success";
                    }
                    else
                    {
                        $errorMessage = "Fail. Retry.";
                    }
                }
            }
            catch (Exception $ex)
            {
                $errorMessage = "Add mod exception";
            }
        }
        return view('hanoivip::admin.mods', ['message' => $message, 'error_message' => $errorMessage]);
    }
    const AGENT_BALANCE_TYPE = 2;
    public function payment(Request $request)
    {
        $options = config('admin.manual_payment_options', []);
        $message = "";
        $errorMessage = "";
        $tid = $request->input('tid');
        if ($request->getMethod() == 'POST')
        {
            $amount = $request->input('amount');
            if (!in_array($amount, $options))
            {
                $errorMessage = 'Invalid amount!';
            }
            else
            {
                $adminId = Auth::user()->getAuthIdentifier();
                if (BalanceFacade::enough($adminId, $amount, self::AGENT_BALANCE_TYPE) !== true)
                {
                    $errorMessage = "Agent is out of money!";
                }
                else 
                {
                    if (BalanceFacade::remove($adminId, $amount, "ManualPayment:$tid", self::AGENT_BALANCE_TYPE) !== true)
                    {
                        $errorMessage = "Subtract admin agent balance fail! Retry!";
                    }
                    else
                    {
                        if (BalanceFacade::add($tid, $amount, "ManualPayment:$adminId") === true)
                        {
                            $message = "Success";
                        }
                        else
                        {
                            $errorMessage = "Fail to add coin for user $tid amount $amount";
                        }
                    }
                }
            }
        }
        
        return view('hanoivip::admin.manual-payment', [
            'options' => $options, 
            'tid' => $tid,
            'message' => $message, 
            'error_message' => $errorMessage]);
    }
}