<?php
/**
 * localized routing (e.g. CONTROLLER-ACTION)
 */

return [
    'user-enable-two-factor' => [
        'route'      => '/enable-two-factor/',
        'method'     => 'App\Controller\UserController:enableTwoFactor',
        'methods'    => ['GET', 'POST'],
        'rolesAllow' => ['member', 'admin', 'superadmin'],
        'rolesDeny'  => [],
    ],
    'user-two-factor' => [
        'route'      => '/two-factor/',
        'method'     => 'App\Controller\UserController:twoFactor',
        'methods'    => ['GET', 'POST'],
        'rolesAllow' => ['guest', 'member', 'admin', 'superadmin'],
        'rolesDeny'  => [],
    ],
    'user-login-success' => [
        'route'      => '/success/',
        'method'     => 'App\Controller\UserController:loginSuccess',
        'methods'    => ['GET'],
        'rolesAllow' => ['member', 'admin', 'superadmin'],
        'rolesDeny'  => [],
    ],
    'user-login-validate' => [
        'route'      => '/validate/',
        'method'     => 'App\Controller\UserController:loginValidate',
        'methods'    => ['POST'],
        'rolesAllow' => ['guest', 'member', 'admin', 'superadmin'],
        'rolesDeny'  => [],
    ],
    'user-show' => [
        'route'      => '/profile/[{name}/]',
        'method'     => 'App\Controller\UserController:show',
        'methods'    => ['GET'],
        'rolesAllow' => ['guest', 'member', 'admin', 'superadmin'],
        'rolesDeny'  => [],
    ],
    'page-example' => [
        'route'      => '/example/',
        'method'     => 'App\Controller\PageController:example',
        'methods'    => ['GET'],
        'rolesAllow' => ['guest', 'member', 'admin', 'superadmin'],
        'rolesDeny'  => [],
    ],
];