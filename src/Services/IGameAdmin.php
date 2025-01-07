<?php

namespace Hanoivip\Admin\Services;

interface IGameAdmin {
    public function initServer($svname, $files = []);
    
    public function applyServer($svname, $files = []);
    
    public function reloadServer($svname);
}