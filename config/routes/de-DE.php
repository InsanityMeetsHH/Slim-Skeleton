<?php
/**
 * localized routing (e.g. CONTROLLER-ACTION)
 */

return [
    'user-enable-two-factor' => [
        'route'      => '/de/zwei-faktor-aktivieren/',
        'method'     => 'App\Controller\UserController:enableTwoFactorAction',
        'methods'    => ['GET', 'POST'],
        'rolesAllow' => ['member', 'admin', 'superadmin'],
        'rolesDeny'  => [],
    ],
    'user-two-factor' => [
        'route'      => '/de/zwei-faktor/',
        'method'     => 'App\Controller\UserController:twoFactorAction',
        'methods'    => ['GET', 'POST'],
        'rolesAllow' => ['guest', 'member', 'admin', 'superadmin'],
        'rolesDeny'  => [],
    ],
    'user-login-success' => [
        'route'      => '/de/erfolg/',
        'method'     => 'App\Controller\UserController:loginSuccessAction',
        'methods'    => ['GET'],
        'rolesAllow' => ['member', 'admin', 'superadmin'],
        'rolesDeny'  => [],
    ],
    'user-login-validate' => [
        'route'      => '/de/validieren/',
        'method'     => 'App\Controller\UserController:loginValidateAction',
        'methods'    => ['POST'],
        'rolesAllow' => ['guest', 'member', 'admin', 'superadmin'],
        'rolesDeny'  => [],
    ],
    'user-show' => [
        'route'      => '/de/profil/[{name}/]',
        'method'     => 'App\Controller\UserController:showAction',
        'methods'    => ['GET'],
        'rolesAllow' => ['guest', 'member', 'admin', 'superadmin'],
        'rolesDeny'  => [],
    ],
    'page-example' => [
        'route'      => '/de/beispiel/',
        'method'     => 'App\Controller\PageController:exampleAction',
        'methods'    => ['GET'],
        'rolesAllow' => ['guest', 'member', 'admin', 'superadmin'],
        'rolesDeny'  => [],
    ],
    'user-register' => [
        'route'      => '/de/registrieren/',
        'method'     => 'App\Controller\UserController:registerAction',
        'methods'    => ['GET'],
        'rolesAllow' => ['guest', 'admin', 'superadmin'],
        'rolesDeny'  => [],
    ],
    'user-add' => [
        'route'      => '/de/registrierung-abschliessen/',
        'method'     => 'App\Controller\UserController:addAction',
        'methods'    => ['POST'],
        'rolesAllow' => ['guest', 'admin', 'superadmin'],
        'rolesDeny'  => [],
    ],
    'user-login' => [
        'route'      => '/de/login/',
        'method'     => 'App\Controller\UserController:loginAction',
        'methods'    => ['GET'],
        'rolesAllow' => ['guest', 'member', 'admin', 'superadmin'],
        'rolesDeny'  => [],
    ],
    'user-logout' => [
        'route'      => '/de/logout/',
        'method'     => 'App\Controller\UserController:logoutAction',
        'methods'    => ['GET'],
        'rolesAllow' => ['guest', 'member', 'admin', 'superadmin'],
        'rolesDeny'  => [],
    ],
    'error-bad-request' => [
        'route'      => '/de/400/',
        'method'     => 'App\Controller\ErrorController:badRequestAction',
        'methods'    => ['GET'],
        'rolesAllow' => ['guest', 'member', 'admin', 'superadmin'],
        'rolesDeny'  => [],
    ],
    'error-not-allowed' => [
        'route'      => '/de/405/',
        'method'     => 'App\Controller\ErrorController:notAllowedAction',
        'methods'    => ['GET'],
        'rolesAllow' => ['guest', 'member', 'admin', 'superadmin'],
        'rolesDeny'  => [],
    ],
    'error-not-found' => [
        'route'      => '/de/404/',
        'method'     => 'App\Controller\ErrorController:notFoundAction',
        'methods'    => ['GET'],
        'rolesAllow' => ['guest', 'member', 'admin', 'superadmin'],
        'rolesDeny'  => [],
    ],
    'error-unauthorized' => [
        'route'      => '/de/401/',
        'method'     => 'App\Controller\ErrorController:unauthorizedAction',
        'methods'    => ['GET'],
        'rolesAllow' => ['guest', 'member', 'admin', 'superadmin'],
        'rolesDeny'  => [],
    ],
    'page-index' => [
        'route'      => '/de/',
        'method'     => 'App\Controller\PageController:indexAction',
        'methods'    => ['GET'],
        'rolesAllow' => ['guest', 'member', 'admin', 'superadmin'],
        'rolesDeny'  => [],
    ],
];