<?php
# See http://php.net/manual/de/function.sprintf.php if you want to use placeholders in strings
return [
    'example' => 'This is a %1$s example page with number %2$s.',
    'db-records' => 'Database records',
    'user' => 'User',
    'password' => 'Password',
    'user-name' => 'User name',
    'login' => 'Login',
    'id' => 'ID',
    'name' => 'Name',
    'role' => 'Role',
    'created-at' => 'Created at',
    'updated-at' => 'Updated at',
    'success' => 'Success',
    'failed-csrf' => 'Failed CSRF check',
    'not-allowed-method' => 'Method must be one of',
    'page-not-found' => 'Page not found',
    'unauthorized' => 'Unauthorized',
    'guest' => 'Guest',
    'member' => 'Member',
    'admin' => 'Admin',
    'superadmin' => 'Superadmin',
    
    // navigation labels
    'page-index-label' => 'Home',
    'page-example-label' => 'Example page',
    'user-show-label' => 'Profile',
    'user-login-label' => 'Login',
    'user-logout-label' => 'Logout',
    'langswitch-label' => 'EN',
    'langswitch-image' => '<img src="https://cdn.rawgit.com/hjnilsson/country-flags/master/svg/us.svg" style="max-height: 20px;">',
    
    // misc
    // decimal point
    'dp' => '.',
    // thousands separator
    'ts' => ',',
    'date' => 'm/d/Y',
    'time' => 'H:i:s',
    'datetime' => 'm/d/Y H:i:s',
    
    // localized routing (e.g. CONTROLLER-ACTION)
    'routes' => [
        'user-login' => [
            'route'      => '/login',
            'method'     => 'App\Controller\UserController:login',
            'methods'    => ['GET'],
            'rolesAllow' => ['guest', 'member', 'admin', 'superadmin'],
            'rolesDeny'  => [],
        ],
        'user-logout' => [
            'route'      => '/logout',
            'method'     => 'App\Controller\UserController:logout',
            'methods'    => ['GET'],
            'rolesAllow' => ['guest', 'member', 'admin', 'superadmin'],
            'rolesDeny'  => [],
        ],
        'user-login-success' => [
            'route'      => '/success',
            'method'     => 'App\Controller\UserController:loginSuccess',
            'methods'    => ['GET'],
            'rolesAllow' => ['member', 'admin', 'superadmin'],
            'rolesDeny'  => [],
        ],
        'user-login-validate' => [
            'route'      => '/validate',
            'method'     => 'App\Controller\UserController:loginValidate',
            'methods'    => ['POST'],
            'rolesAllow' => ['guest', 'member', 'admin', 'superadmin'],
            'rolesDeny'  => [],
        ],
        'user-show' => [
            'route'      => '/profile[/{name}]',
            'method'     => 'App\Controller\UserController:show',
            'methods'    => ['GET'],
            'rolesAllow' => ['guest', 'member', 'admin', 'superadmin'],
            'rolesDeny'  => [],
        ],
        'error-bad-request' => [
            'route'      => '/400',
            'method'     => 'App\Controller\ErrorController:badRequest',
            'methods'    => ['GET'],
            'rolesAllow' => ['guest', 'member', 'admin', 'superadmin'],
            'rolesDeny'  => [],
        ],
        'error-not-allowed' => [
            'route'      => '/405',
            'method'     => 'App\Controller\ErrorController:notAllowed',
            'methods'    => ['GET'],
            'rolesAllow' => ['guest', 'member', 'admin', 'superadmin'],
            'rolesDeny'  => [],
        ],
        'error-not-found' => [
            'route'      => '/404',
            'method'     => 'App\Controller\ErrorController:notFound',
            'methods'    => ['GET'],
            'rolesAllow' => ['guest', 'member', 'admin', 'superadmin'],
            'rolesDeny'  => [],
        ],
        'error-unauthorized' => [
            'route'      => '/401',
            'method'     => 'App\Controller\ErrorController:unauthorized',
            'methods'    => ['GET'],
            'rolesAllow' => ['guest', 'member', 'admin', 'superadmin'],
            'rolesDeny'  => [],
        ],
        'page-example' => [
            'route'      => '/example',
            'method'     => 'App\Controller\PageController:example',
            'methods'    => ['GET'],
            'rolesAllow' => ['guest', 'member', 'admin', 'superadmin'],
            'rolesDeny'  => [],
        ],
        'page-index' => [
            'route'      => '/',
            'method'     => 'App\Controller\PageController:index',
            'methods'    => ['GET'],
            'rolesAllow' => ['guest', 'member', 'admin', 'superadmin'],
            'rolesDeny'  => [],
        ],
    ],
];
