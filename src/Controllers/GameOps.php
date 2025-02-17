<?php

namespace Hanoivip\Admin\Controllers;

use Hanoivip\Admin\Services\IGameAdmin;
use Hanoivip\Admin\Services\ISvn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class GameOps extends Controller
{   
    private $svn;
    
    private $gameAdmin;
    
    private $username;
    
    private $password;
    
    private $dir;
    
    private $url;
    
    private $checkout;
    
    public function __construct(IGameAdmin $gameAdmin, ISvn $svn)
    {
        $this->gameAdmin = $gameAdmin;
        $this->svn = $svn;
        $this->username = config('gameops.svn.username', '');
        $this->password = config('gameops.svn.password', '');
        $this->dir = config('gameops.dir', '/game_ops');
        $this->url = config('gameops.svn.url', '');
        $this->checkout = !File::exists($this->dir);
    }
    
    public function index() {
        return view('hanoivip::admin.gameops');
    }
    
    /**
     * Update from svn to destination
     * @param Request $request
     */
    public function updateSvn(Request $request) {
        if ($this->checkout) {
            $ret = $this->svn->checkout($this->url, $this->dir, $this->username, $this->password);
        }
        else
        {
            $ret = $this->svn->update($this->url, $this->dir, $this->username, $this->password);
        }
        if ($ret === true) {
            $files = $this->svn->list($this->dir, $this->username, $this->password);
            return view('hanoivip::admin.gameops-svn-result', ['message' => 'ok', 'files' => $files]);
        }
        else {
            return view('hanoivip::admin.gameops-svn-result', ['error_message' => $ret]);
        }
    }
    
    public function initGame(Request $request) {
        $serverId = $request->input('svname');
        $files = $this->svn->list($this->dir, $this->username, $this->password);
        if (!empty($files)) {
            $ret = $this->gameAdmin->initServer($serverId, $files);
        }
        if ($ret === true) {
            return view('hanoivip::admin.gameops-svn-result', ['message' => 'ok']);
        }
        else {
            return view('hanoivip::admin.gameops-svn-result', ['error_message' => $ret]);
        }
    }
    
    public function applyGame(Request $request) {
        $serverId = $request->input('svname');
        $files = $this->svn->list($this->dir, $this->username, $this->password);
        if (!empty($files)) {
            $ret = $this->gameAdmin->applyServer($serverId, $files);
        }
        if ($ret === true) {
            return view('hanoivip::admin.gameops-svn-result', ['message' => 'ok']);
        }
        else {
            return view('hanoivip::admin.gameops-svn-result', ['error_message' => $ret]);
        }
    }
}