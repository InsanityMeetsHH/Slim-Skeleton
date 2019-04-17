<?php
/**
 * Theses routes fits all locales
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
    'user-register' => [
        'route'      => '/register/',
        'method'     => 'App\Controller\UserController:registerAction',
        'methods'    => ['GET'],
        'rolesAllow' => ['guest', 'admin', 'superadmin'],
        'rolesDeny'  => [],
    ],
    'user-register-save' => [
        'route'      => '/complete-register/',
        'method'     => 'App\Controller\UserController:saveRegisterAction',
        'methods'    => ['POST'],
        'rolesAllow' => ['guest', 'admin', 'superadmin'],
        'rolesDeny'  => [],
    ],
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