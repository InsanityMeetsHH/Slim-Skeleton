<?php
return [
    'settings' => [
        'displayErrorDetails' => FALSE, // set to false in production
        
        // Doctrine settings
        'doctrine' => [
            'connection' => [
                'dbname'   => '',
                'user'     => '',
                'password' => '',
            ],
        ],
        
        // Google recaptcha
        'recaptcha' => [
            'site'   => '',
            'secret' => '',
        ],
        
        // Locale settings
        'locale' => [
            'process' => \App\Utility\LanguageUtility::LOCALE_URL | \App\Utility\LanguageUtility::DOMAIN_DISABLED,
            'default_domain' => 'imhh-slim.localhost',
            'active' => [
//                'xx-XX' => '', // domain not necessary here
                'en-US' => 'imhh-slim.localhost',
                'de-DE' => 'de.imhh-slim.localhost',
            ],
        ],
        
        // Relative to domain (e.g. project is in sub directory '/project/public/')
        'public_path' => '/',
    ],
];
