<?php
# See http://php.net/manual/de/function.sprintf.php if you want to use placeholders in strings
return [
    'hello' => 'Hello',
    'microfw' => 'a microframework for PHP',
    'try' => 'Try',
    'example' => 'This is a %1$s example page with number %2$s.',
    'db-records' => 'Database records',
    
    // navigation labels
    'page-index-label' => 'Home',
    'page-example-label' => 'Example page',
    'user-login-label' => 'Login',
    'user-logout-label' => 'Logout',
    
    // localized routing (e.g. CONTROLLER-ACTION)
    'langswitch-label' => 'EN',
    'langswitch-image' => '<img src="https://cdn.rawgit.com/hjnilsson/country-flags/master/svg/us.svg" style="max-height: 20px;">',
    'page-index' => '/[{name}]',
    'page-example' => '/example',
    'user-login' => '/login',
    'user-logout' => '/logout',
    'user-login-success' => '/success',
    'user-login-validate' => '/validate',
    
    // misc
    // decimal point
    'dp' => '.',
    // thousands separator
    'ts' => ',',
];
