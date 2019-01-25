<?php
return [
    'settings' => [
        'displayErrorDetails' => FALSE, // set to false in production
        
        // Doctrine settings
        'doctrine' => [
            'connection' => [
                'dbname'   => isset($_ENV['APP_DB_NAME']) ? $_ENV['APP_DB_NAME'] : 'slim_database',
                'host'     => isset($_ENV['APP_DB_HOST']) ? $_ENV['APP_DB_HOST'] : '127.0.0.1',
                'port'     => isset($_ENV['APP_DB_PORT']) ? $_ENV['APP_DB_PORT'] : 3306,
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
            'auto_detect' => TRUE,
            'code' => 'en-US', // default / current language
            'active' => [
                'en-US' => 'imhh-slim.localhost',
                'de-DE' => 'de.imhh-slim.localhost',
            ],
        ],
    ],
];
