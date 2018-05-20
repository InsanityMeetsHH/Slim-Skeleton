<?php
# See http://php.net/manual/de/function.sprintf.php if you want to use placeholders in strings
return [
    'example' => 'Dies ist eine %1$s Beispielseite mit Nummer %2$s.',
    'db-records' => 'Datenbank-Datensätze',
    'user' => 'Benutzer',
    'password' => 'Passwort',
    'user-name' => 'Benutzername',
    'login' => 'Login',
    'id' => 'ID',
    'name' => 'Name',
    'role' => 'Rolle',
    'created-at' => 'Erstellt am',
    'updated-at' => 'Bearbeitet am',
    'success' => 'Erfolg',
    'failed-csrf' => 'CSRF-Prüfung nicht bestanden',
    'not-allowed-method' => 'Methode muss eine der folgenden sein',
    'page-not-found' => 'Seite nicht gefunden',
    'unauthorized' => 'Nicht authorisiert',
    'guest' => 'Gast',
    'member' => 'Mitglied',
    'admin' => 'Admin',
    'superadmin' => 'Superadmin',
    
    // navigation labels
    'page-index-label' => 'Startseite',
    'page-example-label' => 'Beispielseite',
    'user-show-label' => 'Profil',
    'user-login-label' => 'Login',
    'user-logout-label' => 'Logout',
    'langswitch-label' => 'DE',
    'langswitch-image' => '<img src="https://cdn.rawgit.com/hjnilsson/country-flags/master/svg/de.svg" style="max-height: 20px;">',
    
    // misc
    // decimal point
    'dp' => ',',
    // thousands separator
    'ts' => '.',
    'date' => 'd.m.Y',
    'time' => 'H:i:s',
    'datetime' => 'd.m.Y H:i:s',
    
    // localized routing (e.g. CONTROLLER-ACTION)
    'routes' => [
        'user-login' => [
            'route'      => '/de/login',
            'method'     => 'App\Controller\UserController:login',
            'methods'    => ['GET'],
            'rolesAllow' => ['guest', 'member', 'admin', 'superadmin'],
            'rolesDeny'  => [],
        ],
        'user-logout' => [
            'route'      => '/de/logout',
            'method'     => 'App\Controller\UserController:logout',
            'methods'    => ['GET'],
            'rolesAllow' => ['guest', 'member', 'admin', 'superadmin'],
            'rolesDeny'  => [],
        ],
        'user-login-success' => [
            'route'      => '/de/erfolg',
            'method'     => 'App\Controller\UserController:loginSuccess',
            'methods'    => ['GET'],
            'rolesAllow' => ['member', 'admin', 'superadmin'],
            'rolesDeny'  => [],
        ],
        'user-login-validate' => [
            'route'      => '/de/validate',
            'method'     => 'App\Controller\UserController:loginValidate',
            'methods'    => ['POST'],
            'rolesAllow' => ['guest', 'member', 'admin', 'superadmin'],
            'rolesDeny'  => [],
        ],
        'user-show' => [
            'route'      => '/de/profil[/{name}]',
            'method'     => 'App\Controller\UserController:show',
            'methods'    => ['GET'],
            'rolesAllow' => ['guest', 'member', 'admin', 'superadmin'],
            'rolesDeny'  => [],
        ],
        'error-bad-request' => [
            'route'      => '/de/400',
            'method'     => 'App\Controller\ErrorController:badRequest',
            'methods'    => ['GET'],
            'rolesAllow' => ['guest', 'member', 'admin', 'superadmin'],
            'rolesDeny'  => [],
        ],
        'error-not-allowed' => [
            'route'      => '/de/405',
            'method'     => 'App\Controller\ErrorController:notAllowed',
            'methods'    => ['GET'],
            'rolesAllow' => ['guest', 'member', 'admin', 'superadmin'],
            'rolesDeny'  => [],
        ],
        'error-not-found' => [
            'route'      => '/de/404',
            'method'     => 'App\Controller\ErrorController:notFound',
            'methods'    => ['GET'],
            'rolesAllow' => ['guest', 'member', 'admin', 'superadmin'],
            'rolesDeny'  => [],
        ],
        'error-unauthorized' => [
            'route'      => '/de/401',
            'method'     => 'App\Controller\ErrorController:unauthorized',
            'methods'    => ['GET'],
            'rolesAllow' => ['guest', 'member', 'admin', 'superadmin'],
            'rolesDeny'  => [],
        ],
        'page-example' => [
            'route'      => '/de/beispiel',
            'method'     => 'App\Controller\PageController:example',
            'methods'    => ['GET'],
            'rolesAllow' => ['guest', 'member', 'admin', 'superadmin'],
            'rolesDeny'  => [],
        ],
        'page-index' => [
            'route'      => '/de/',
            'method'     => 'App\Controller\PageController:index',
            'methods'    => ['GET'],
            'rolesAllow' => ['guest', 'member', 'admin', 'superadmin'],
            'rolesDeny'  => [],
        ],
    ],
];
