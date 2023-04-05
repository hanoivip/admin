<?php

namespace Hanoivip\Admin\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Exception;
use Hanoivip\Admin\Requests\AddBalance;
use Hanoivip\Admin\Requests\AddServer;
use Hanoivip\Admin\Requests\AdminRequest;
use Hanoivip\Admin\Requests\RemoveServer;
use Hanoivip\Payment\Facades\BalanceFacade;
use Hanoivip\User\Facades\UserFacade;
use Hanoivip\Events\Game\UserRecharge;
use Hanoivip\Events\Gate\UserTopup;
use Hanoivip\Game\Facades\GameHelper;
use Hanoivip\Game\Facades\ServerFacade;
use Hanoivip\Admin\IUserOperator;
use Hanoivip\Events\Server\ServerCreated;
use Hanoivip\Admin\Services\AdminService;

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
    
    public function detailUser(AdminRequest $request)
    {
        $tid = $request->input('tid');
        try
        {
            $info = $this->passport->fetchAllInfo($tid);
            //Log::debug('Passport fetch user info:' . print_r($info, true));
            if (empty($info))
                return view('hanoivip::admin.user-find', ['error_message' => __('hanoivip.admin::admin.user.not-found')]);
            else
                return view('hanoivip::admin.user-detail',
                    ['tid' => $info['id'], 'personal' => $info['personal'], 'secure' => $info['secure']]);
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
                $message = __('hanoivip.admin::admin.user.reset-pass.success');
            else 
                $error_message = __('hanoivip.admin::admin.user.reset-pass.fail');
        }
        catch (Exception $ex)
        {
            Log::error('Admin reset user password exception: ' . $ex->getMessage());
            $error_message = __('hanoivip.admin::admin.user.reset-pass.exception');
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
        $reason = "Admin $userId add $tid";
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
            else if (BalanceFacade::add($tid, $balance, $reason))
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
            else if (BalanceFacade::remove($tid, $balance, $reason))
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
    
    public function serverInfo()
    {
        $all = ServerFacade::getAll();
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
            $record = ServerFacade::addNew($params);
            event(new ServerCreated($record));
            $message = __('hanoivip.admin::admin.user.add-server.success');
        }
        catch (Exception $ex)
        {
            Log::error('Admin add server exception: ' . $ex->getMessage());
            $error_message = __('hanoivip.admin::admin.user.add-server.exception');
        }
        return view('hanoivip::admin.server-result',
            ['message' => $message, 'error_message' => $error_message]);
    }
    
    public function removeServer(RemoveServer $request)
    {
        $ident = $request->input('ident');
        $message = '';
        $error_message = '';
        try
        {
            ServerFacade::removeByIdent($ident);
            $message = __('hanoivip.admin::admin.user.remove-server.success');
        }
        catch (Exception $ex)
        {
            Log::error('Admin remove server exception: ' . $ex->getMessage());
            $error_message = __('hanoivip.admin::admin.user.remove-server.exception');
        }
        return view('hanoivip::admin.server-result',
            ['message' => $message, 'error_message' => $error_message]);
    }
    
    public function recharge(Request $request)
    {
        $tid = $request->input('tid');
        $servers = ServerFacade::getAll();
        $packages = GameHelper::getRechargePackages();
        $selected = $servers->first();
        if ($request->has('svname'))
            $selected = $request->input('svname');
        $roles = GameHelper::getRoles($selected, $tid);
        $data = [ 'servers' => $servers, 'packs' => $packages,
            'roles' => $roles, 'tid' => $tid, 'selected' => $selected];
        return view('hanoivip::admin.recharge', $data);
    }
    
    public function doRecharge(Request $request)
    {
        $tid = $request->input('tid');
        $server = $request->input('svname');
        $package = $request->input('package');
        $roleid = $request->input('roleid');
        $uid = Auth::user()->getAuthIdentifier();
        $result = GameHelper::recharge($uid, $server, $package, $roleid, $tid);
        if ($result === true)
            return view('hanoivip::admin.recharge-success');
        else
            return view('hanoivip::admin.recharge-fail', ['error' => $result]);
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
                $result = $this->admin->addRole($user->id, "Mod", "mod");
                if ($result)
                {
                    $message = "Add mod success";
                }
            }
            catch (Exception $ex)
            {
                $errorMessage = "Add mod exception";
            }
        }
        return view('hanoivip::admin.mods', ['message' => $message, 'error_message' => $errorMessage]);
    }
}