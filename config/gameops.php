<?php

return [
    'svn' => [
        'url' => env('GAMEOPS_SVN_URL', ''),
        'username' => env('GAMEOPS_SVN_USERNAME', 'ops'),
        'password' => env('GAMEOPS_SVN_PASSWORD', 'Ops@2025!'),
    ],
    'dir' => '/game_ops',
];