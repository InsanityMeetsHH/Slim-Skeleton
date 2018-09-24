<?php
return [
    'settings' => [
        'displayErrorDetails' => FALSE, // set to false in production
        
        // Doctrine settings
        'doctrine' => [
            'connection' => [
                'host'     => 'localhost',
                'port'     => isset($_ENV['APP_DB_PORT']) ? $_ENV['APP_DB_PORT'] : 3306,
                'dbname'   => isset($_ENV['APP_DB_NAME']) ? $_ENV['APP_DB_NAME'] : '',
                'user'     => isset($_ENV['APP_DB_USER']) ? $_ENV['APP_DB_USER'] : '',
                'password' => isset($_ENV['APP_DB_PASSWORD']) ? $_ENV['APP_DB_PASSWORD'] : '',
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
            'active' => [
                'en-US' => 'imhh-slim.localhost',
                'de-DE' => 'de.imhh-slim.localhost',
            ],
        ],
        
        // Relative to domain (e.g. project is in sub directory '/project/public/')
        'public_path' => '/',
    ],
];
