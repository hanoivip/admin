<?php

namespace Hanoivip\Admin\Controllers;

use Illuminate\Http\Request;
use Hanoivip\Game\Recharge;
use Hanoivip\GameContracts\Contracts\IGameOperator;
use Hanoivip\Game\Facades\ServerFacade;
use Hanoivip\GameContracts\ViewObjects\UserVO;
/**
 * Actor: subsystem
 * 
 * TODO: Need a guard
 * 
 * @author gameo
 *
 */
class OpsController extends Controller
{
    private $game;
    
    public function __construct(IGameOperator $game)
    {
        $this->game = $game;
    }
    
    public function recharge(Request $request)
    {
        $uid = $request->input('uid');
        $roleid = $request->input('roleid');
        $packageCode = $request->input('package');
        $svname = $request->input('svname');
        $mapping = $request->input('mapping');
        $server = ServerFacade::getServerByName($svname);
        $package = Recharge::where('code', $packageCode)->first();
        $result = $this->game->recharge(new UserVO($uid, ""), $server, $mapping, $package, ['roleid' => $roleid]);
        if ($result)
            return ['error' => 0];
        else
            return ['error' => 1];
    }
    
}