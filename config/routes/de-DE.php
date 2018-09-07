<?php
/**
 * localized routing (e.g. CONTROLLER-ACTION)
 */

return [
    'user-enable-two-factor' => [
        'route'      => '/zwei-faktor-aktivieren/',
        'method'     => 'App\Controller\UserController:enableTwoFactorAction',
        'methods'    => ['GET', 'POST'],
        'rolesAllow' => ['member', 'admin', 'superadmin'],
        'rolesDeny'  => [],
    ],
    'user-two-factor' => [
        'route'      => '/zwei-faktor/',
        'method'     => 'App\Controller\UserController:twoFactorAction',
        'methods'    => ['GET', 'POST'],
        'rolesAllow' => ['guest', 'member', 'admin', 'superadmin'],
        'rolesDeny'  => [],
    ],
    'user-login-success' => [
        'route'      => '/erfolg/',
        'method'     => 'App\Controller\UserController:loginSuccessAction',
        'methods'    => ['GET'],
        'rolesAllow' => ['member', 'admin', 'superadmin'],
        'rolesDeny'  => [],
    ],
    'user-login-validate' => [
        'route'      => '/validieren/',
        'method'     => 'App\Controller\UserController:loginValidateAction',
        'methods'    => ['POST'],
        'rolesAllow' => ['guest', 'member', 'admin', 'superadmin'],
        'rolesDeny'  => [],
    ],
    'user-show' => [
        'route'      => '/profil/[{name}/]',
        'method'     => 'App\Controller\UserController:showAction',
        'methods'    => ['GET'],
        'rolesAllow' => ['guest', 'member', 'admin', 'superadmin'],
        'rolesDeny'  => [],
    ],
    'page-example' => [
        'route'      => '/beispiel/',
        'method'     => 'App\Controller\PageController:exampleAction',
        'methods'    => ['GET'],
        'rolesAllow' => ['guest', 'member', 'admin', 'superadmin'],
        'rolesDeny'  => [],
    ],
];