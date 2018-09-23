<?php
/**
 * Theses routes fits all locales
 * localized routing (e.g. CONTROLLER-ACTION)
 */

return [
    'user-login' => [
        'route'      => '/login/',
        'method'     => 'App\Controller\UserController:loginAction',
        'methods'    => ['GET'],
        'rolesAllow' => ['guest', 'member', 'admin', 'superadmin'],
        'rolesDeny'  => [],
    ],
    'user-logout' => [
        'route'      => '/logout/',
        'method'     => 'App\Controller\UserController:logoutAction',
        'methods'    => ['GET'],
        'rolesAllow' => ['guest', 'member', 'admin', 'superadmin'],
        'rolesDeny'  => [],
    ],
    'error-bad-request' => [
        'route'      => '/400/',
        'method'     => 'App\Controller\ErrorController:badRequestAction',
        'methods'    => ['GET'],
        'rolesAllow' => ['guest', 'member', 'admin', 'superadmin'],
        'rolesDeny'  => [],
    ],
    'error-not-allowed' => [
        'route'      => '/405/',
        'method'     => 'App\Controller\ErrorController:notAllowedAction',
        'methods'    => ['GET'],
        'rolesAllow' => ['guest', 'member', 'admin', 'superadmin'],
        'rolesDeny'  => [],
    ],
    'error-not-found' => [
        'route'      => '/404/',
        'method'     => 'App\Controller\ErrorController:notFoundAction',
        'methods'    => ['GET'],
        'rolesAllow' => ['guest', 'member', 'admin', 'superadmin'],
        'rolesDeny'  => [],
    ],
    'error-unauthorized' => [
        'route'      => '/401/',
        'method'     => 'App\Controller\ErrorController:unauthorizedAction',
        'methods'    => ['GET'],
        'rolesAllow' => ['guest', 'member', 'admin', 'superadmin'],
        'rolesDeny'  => [],
    ],
    'page-index' => [
        'route'      => '/',
        'method'     => 'App\Controller\PageController:indexAction',
        'methods'    => ['GET'],
        'rolesAllow' => ['guest', 'member', 'admin', 'superadmin'],
        'rolesDeny'  => [],
    ],
];