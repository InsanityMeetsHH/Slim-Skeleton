<?php
$currentRole = 'guest';

if (isset($_SESSION['currentRole'])) {
    $currentRole = $_SESSION['currentRole'];
} else {
    $_SESSION['currentRole'] = $currentRole;
}

$allResources = [
    '/', '/[{name}]', '/de/[{name}]', '/example', '/de/beispiel', 
    '/login', '/de/login', '/logout', '/de/logout', '/success', '/de/erfolg', 
    '/validate', '/de/validate', '/de/profil', '/profile', '/de/backend', '/backend'
];
$geustAllowResources = [
    '/', '/[{name}]', '/de/[{name}]', '/example', '/de/beispiel', '/login', '/de/login', 
    '/logout', '/de/logout', '/success', '/de/erfolg', '/validate', '/de/validate'
];
$memberAllowResources = array_merge($geustAllowResources, ['/de/profil', '/profile']);
$adminAllowResources = array_merge($memberAllowResources, ['/de/backend', '/backend']);

$app->add(\App\Utility\AclUtility::setup([$currentRole], 
    [
        'resources' => $allResources,
        'roles' => ['guest', 'member', 'admin'],
        'assignments' => [
            'allow' => [
                'guest' => $geustAllowResources,
                'member' => $memberAllowResources,
                'admin' => $adminAllowResources
            ],
            'deny' => [
//                'guest' => ['/profile', '/backend'],
//                'member' => ['/backend']
            ]
        ]
    ]
));

$app->add($container->get('csrf'));
