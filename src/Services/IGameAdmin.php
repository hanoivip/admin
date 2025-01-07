<?php

namespace Hanoivip\Admin\Services;

interface IGameAdmin {
    public function initServer($serverId, $files = []);
    
    public function applyServer($serverId, $files = []);
    
    public function reloadServer($serverId);
}