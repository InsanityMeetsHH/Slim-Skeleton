<?php
# See http://php.net/manual/de/function.sprintf.php if you want to use placeholders in strings
return [
    'hello' => 'Hello',
    'microfw' => 'a microframework for PHP',
    'try' => 'Try',
    'example' => 'This is a %1$s example page with number %2$s.',
    'db-records' => 'Database records',
    
    // navigation labels
    'page-index-label' => 'Home',
    'page-example-label' => 'Example page',
    'user-login-label' => 'Login',
    'user-logout-label' => 'Logout',
    'langswitch-label' => 'EN',
    'langswitch-image' => '<img src="https://cdn.rawgit.com/hjnilsson/country-flags/master/svg/us.svg" style="max-height: 20px;">',
    
    // localized routing (e.g. CONTROLLER-ACTION)
    'routes' => [
        'user-login' => [
            'route'      => '/login',
            'method'     => 'App\Controller\UserController:login',
            'methods'    => ['GET'],
            'rolesAllow' => ['guest', 'member', 'admin'],
            'rolesDeny'  => [],
        ],
        'user-logout' => [
            'route'      => '/logout',
            'method'     => 'App\Controller\UserController:logout',
            'methods'    => ['GET'],
            'rolesAllow' => ['guest', 'member', 'admin'],
            'rolesDeny'  => [],
        ],
        'user-login-success' => [
            'route'      => '/success',
            'method'     => 'App\Controller\UserController:loginSuccess',
            'methods'    => ['GET'],
            'rolesAllow' => ['member', 'admin'],
            'rolesDeny'  => [],
        ],
        'user-login-validate' => [
            'route'      => '/validate',
            'method'     => 'App\Controller\UserController:loginValidate',
            'methods'    => ['POST'],
            'rolesAllow' => ['guest', 'member', 'admin'],
            'rolesDeny'  => [],
        ],
        'page-example' => [
            'route'      => '/example',
            'method'     => 'App\Controller\PageController:example',
            'methods'    => ['GET'],
            'rolesAllow' => ['guest', 'member', 'admin'],
            'rolesDeny'  => [],
        ],
        'page-index' => [
            'route'      => '/[{name}]',
            'method'     => 'App\Controller\PageController:index',
            'methods'    => ['GET'],
            'rolesAllow' => ['guest', 'member', 'admin'],
            'rolesDeny'  => [],
        ],
    ],
    
    // misc
    // decimal point
    'dp' => '.',
    // thousands separator
    'ts' => ',',
    'date' => 'm/d/Y',
    'time' => 'H:i:s',
    'datetime' => 'm/d/Y H:i:s',
];
