<?php
# See http://php.net/manual/de/function.sprintf.php if you want to use placeholders in strings
return [
    'hello' => 'Hallo',
    'microfw' => 'ein microframework für PHP',
    'try' => 'Probiere',
    'example' => 'Dies ist eine %1$s Beispielseite mit Nummer %2$s.',
    'db-records' => 'Datenbank-Datensätze',
    
    // navigation labels
    'page-index-label' => 'Startseite',
    'page-example-label' => 'Beispielseite',
    'user-login-label' => 'Login',
    'user-logout-label' => 'Logout',
    
    // localized routing (e.g. CONTROLLER-ACTION)
    'langswitch-label' => 'DE',
    'langswitch-image' => '<img src="https://cdn.rawgit.com/hjnilsson/country-flags/master/svg/de.svg" style="max-height: 20px;">',
    'page-index' => '/de/[{name}]',
    'page-example' => '/de/beispiel',
    'user-login' => '/de/login',
    'user-logout' => '/de/logout',
    'user-login-success' => '/de/erfolg',
    'user-login-validate' => '/de/validate',
    
    // misc
    // decimal point
    'dp' => ',',
    // thousands separator
    'ts' => '.',
];
