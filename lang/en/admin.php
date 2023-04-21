<?php

return [
    'balance' => [
        'add' => [
            'denied' => 'Deny to add coin to that player',
            'success' => 'Request to add success, need wait for approval',
            'fail' => 'Add coin failure. Retry.',
            'exception' => 'Add coin error. Retry',
        ],
        'remove' => [
            'denied' => 'Deny to remove coin to that player',
            'success' => 'Request to remove success, need wait for approval',
            'fail' => 'Remove coin failure. Retry.',
            'exception' => 'Remove coin error. Retry',
        ],
    ],
    'user' => [
        'not-found' => 'User not found!',
    ],
    'logas' => [
        'user-not-exists' =>'User not found',
        'user-is-mod' => 'Can not log in another mod/smod/admin user'
    ],
    'reset-pass' => [
        'success' => 'Reset pass success',
        'fail' => 'Failure',
        'exception' => 'Exception..'
    ]
];