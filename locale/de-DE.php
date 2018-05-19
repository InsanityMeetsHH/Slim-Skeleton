<?php
# See http://php.net/manual/de/function.sprintf.php if you want to use placeholders in strings
return [
    'hello' => 'Hallo',
    'microfw' => 'ein microframework für PHP',
    'try' => 'Probiere',
    'example' => 'Dies ist eine %1$s Beispielseite mit Nummer %2$s.',
    'db-records' => 'Datenbank-Datensätze',
    
    // navigation labels
    'page-index-label' => 'Startseite',
    'page-example-label' => 'Beispielseite',
    'user-login-label' => 'Login',
    'user-logout-label' => 'Logout',
    'langswitch-label' => 'DE',
    'langswitch-image' => '<img src="https://cdn.rawgit.com/hjnilsson/country-flags/master/svg/de.svg" style="max-height: 20px;">',
    
    // localized routing (e.g. CONTROLLER-ACTION)
    'routes' => [
        'user-login' => [
            'route'      => '/de/login',
            'method'     => 'App\Controller\UserController:login',
            'methods'    => ['GET'],
            'rolesAllow' => ['guest', 'member', 'admin'],
            'rolesDeny'  => [],
        ],
        'user-logout' => [
            'route'      => '/de/logout',
            'method'     => 'App\Controller\UserController:logout',
            'methods'    => ['GET'],
            'rolesAllow' => ['guest', 'member', 'admin'],
            'rolesDeny'  => [],
        ],
        'user-login-success' => [
            'route'      => '/de/erfolg',
            'method'     => 'App\Controller\UserController:loginSuccess',
            'methods'    => ['GET'],
            'rolesAllow' => ['member', 'admin'],
            'rolesDeny'  => [],
        ],
        'user-login-validate' => [
            'route'      => '/de/validate',
            'method'     => 'App\Controller\UserController:loginValidate',
            'methods'    => ['POST'],
            'rolesAllow' => ['guest', 'member', 'admin'],
            'rolesDeny'  => [],
        ],
        'page-example' => [
            'route'      => '/de/beispiel',
            'method'     => 'App\Controller\PageController:example',
            'methods'    => ['GET'],
            'rolesAllow' => ['guest', 'member', 'admin'],
            'rolesDeny'  => [],
        ],
        'page-index' => [
            'route'      => '/de/[{name}]',
            'method'     => 'App\Controller\PageController:index',
            'methods'    => ['GET'],
            'rolesAllow' => ['guest', 'member', 'admin'],
            'rolesDeny'  => [],
        ],
    ],
    
    // misc
    // decimal point
    'dp' => ',',
    // thousands separator
    'ts' => '.',
    'date' => 'd.m.Y',
    'time' => 'H:i:s',
    'datetime' => 'd.m.Y H:i:s',
];
