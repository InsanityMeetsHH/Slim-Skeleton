<?php
/**
 * localized routing (e.g. CONTROLLER-ACTION)
 */

return [
    'user-enable-two-factor' => [
        'route'      => '/enable-two-factor/',
        'method'     => 'App\Controller\UserController:enableTwoFactorAction',
        'methods'    => ['GET', 'POST'],
        'rolesAllow' => ['member', 'admin', 'superadmin'],
        'rolesDeny'  => [],
    ],
    'user-two-factor' => [
        'route'      => '/two-factor/',
        'method'     => 'App\Controller\UserController:twoFactorAction',
        'methods'    => ['GET', 'POST'],
        'rolesAllow' => ['guest', 'member', 'admin', 'superadmin'],
        'rolesDeny'  => [],
    ],
    'user-login-success' => [
        'route'      => '/success/',
        'method'     => 'App\Controller\UserController:loginSuccessAction',
        'methods'    => ['GET'],
        'rolesAllow' => ['member', 'admin', 'superadmin'],
        'rolesDeny'  => [],
    ],
    'user-login-validate' => [
        'route'      => '/validate/',
        'method'     => 'App\Controller\UserController:loginValidateAction',
        'methods'    => ['POST'],
        'rolesAllow' => ['guest', 'member', 'admin', 'superadmin'],
        'rolesDeny'  => [],
    ],
    'user-show' => [
        'route'      => '/profile/[{name}/]',
        'method'     => 'App\Controller\UserController:showAction',
        'methods'    => ['GET'],
        'rolesAllow' => ['guest', 'member', 'admin', 'superadmin'],
        'rolesDeny'  => [],
    ],
    'page-example' => [
        'route'      => '/example/',
        'method'     => 'App\Controller\PageController:exampleAction',
        'methods'    => ['GET'],
        'rolesAllow' => ['guest', 'member', 'admin', 'superadmin'],
        'rolesDeny'  => [],
    ],
];