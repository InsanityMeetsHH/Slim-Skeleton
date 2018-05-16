<?php
$loggedIn = FALSE;
$currentRole = 'guest';
if ($loggedIn) {
    $currentRole = 'member';
}

$app->add(\App\Utility\AclUtility::setup([$currentRole], 
    [
        'resources' => ['/', '/[{name}]', '/de/[{name}]', '/example', '/de/beispiel', '/profile', '/backend'],
        'roles' => ['guest', 'member', 'admin'],
        'assignments' => [
            'allow' => [
                'guest' => ['/', '/[{name}]', '/de/[{name}]', '/example', '/de/beispiel'],
                'member' => ['/', '/profile'],
                'admin' => ['/', '/backend']
            ],
            'deny' => [
                'guest' => ['/profile', '/backend'],
                'member' => ['/backend']
            ]
        ]
    ]
));
