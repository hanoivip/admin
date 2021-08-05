<?php

namespace Hanoivip\Admin\Controllers;

use Hanoivip\Admin\Services\PassportClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Exception;
use Hanoivip\Admin\Requests\AddBalance;
use Hanoivip\Admin\Requests\AddServer;
use Hanoivip\Admin\Requests\AdminRequest;
use Hanoivip\Admin\Requests\RemoveServer;
use Hanoivip\Payment\Facades\BalanceFacade;
use Hanoivip\Payment\Services\NewTopupService;
use Hanoivip\Events\Game\UserRecharge;
use Hanoivip\Events\Gate\UserTopup;
use Hanoivip\Game\Facades\GameHelper;
use Hanoivip\Game\Facades\ServerFacade;
/**
 * Actor: admin
 * @author gameo
 *
 */
class AdminController extends Controller
{
    protected $passport;
    
    protected $topup;
    
    public function __construct(
        PassportClient $passport,
        NewTopupService $topup)
    {
        $this->passport = $passport;
        $this->topup = $topup;
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
                    ['tid' => $info['id'], 'personal' => $info['personal'], 'secure' => $info['secure']]);
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
    
    public function testActivity(AdminRequest $request)
    {
        $tid = $request->input('tid');
        return view('hanoivip::admin.activity-test', ['tid' => $tid]);
    }
    
    public function fakeTopup(AdminRequest $request)
    {
        $tid = $request->input('tid');
        $coin = $request->input('topup');
        event(new UserTopup($tid, 0, $coin, ""));
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
            if (BalanceFacade::add($tid, $balance, $reason))
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
        $submits = $this->topup->getHistory($tid);
        $mods = BalanceFacade::getHistory($tid);
        return view('hanoivip::admin.balance-history', 
            ['tid' => $tid,'submits' => $submits[0], 'mods' => $mods[0]]);
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
            ServerFacade::addNew($params);
            $message = __('admin.user.add-server.success');
        }
        catch (Exception $ex)
        {
            Log::error('Admin add server exception: ' . $ex->getMessage());
            $error_message = __('admin.user.add-server.exception');
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
            $message = __('admin.user.remove-server.success');
        }
        catch (Exception $ex)
        {
            Log::error('Admin remove server exception: ' . $ex->getMessage());
            $error_message = __('admin.user.remove-server.exception');
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
}