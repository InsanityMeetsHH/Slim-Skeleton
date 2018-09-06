<?php
/**
 * This routes fits all locales
 * localized routing (e.g. CONTROLLER-ACTION)
 */

return [
    'user-login' => [
        'route'      => '/login/',
        'method'     => 'App\Controller\UserController:login',
        'methods'    => ['GET'],
        'rolesAllow' => ['guest', 'member', 'admin', 'superadmin'],
        'rolesDeny'  => [],
    ],
    'user-logout' => [
        'route'      => '/logout/',
        'method'     => 'App\Controller\UserController:logout',
        'methods'    => ['GET'],
        'rolesAllow' => ['guest', 'member', 'admin', 'superadmin'],
        'rolesDeny'  => [],
    ],
    'error-bad-request' => [
        'route'      => '/400/',
        'method'     => 'App\Controller\ErrorController:badRequest',
        'methods'    => ['GET'],
        'rolesAllow' => ['guest', 'member', 'admin', 'superadmin'],
        'rolesDeny'  => [],
    ],
    'error-not-allowed' => [
        'route'      => '/405/',
        'method'     => 'App\Controller\ErrorController:notAllowed',
        'methods'    => ['GET'],
        'rolesAllow' => ['guest', 'member', 'admin', 'superadmin'],
        'rolesDeny'  => [],
    ],
    'error-not-found' => [
        'route'      => '/404/',
        'method'     => 'App\Controller\ErrorController:notFound',
        'methods'    => ['GET'],
        'rolesAllow' => ['guest', 'member', 'admin', 'superadmin'],
        'rolesDeny'  => [],
    ],
    'error-unauthorized' => [
        'route'      => '/401/',
        'method'     => 'App\Controller\ErrorController:unauthorized',
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
];