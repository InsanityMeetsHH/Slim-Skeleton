<?php
return [
    'settings' => [
        'displayErrorDetails' => FALSE, // set to false in production

        // Renderer settings
        'renderer' => [
            'debug' => FALSE,
            'cache' => FALSE, // FALSE or path to cache folder "__DIR__ . '/../cache/'"
        ],
        
        // Doctrine settings
        'doctrine' => [
            'connection' => [
                'dbname'      => isset($_ENV['APP_DB_NAME']) ? $_ENV['APP_DB_NAME'] : 'slim_skeleton',
                'host'        => isset($_ENV['APP_DB_HOST']) ? $_ENV['APP_DB_HOST'] : 'localhost',
                'port'        => isset($_ENV['APP_DB_PORT']) ? $_ENV['APP_DB_PORT'] : 3306,
                'user'        => isset($_ENV['APP_DB_USER']) ? $_ENV['APP_DB_USER'] : '',
                'password'    => isset($_ENV['APP_DB_PASSWORD']) ? $_ENV['APP_DB_PASSWORD'] : '',
                'unix_socket' => isset($_ENV['APP_DB_SOCKET']) ? $_ENV['APP_DB_SOCKET'] : '',
            ],
        ],
        
        // Google recaptcha
        'recaptcha' => [
            'site'   => '',
            'secret' => '',
        ],
        
        // Google QR Code title
        '2fa_qrc_title' => null,
        
        // pages for the public
        'active_pages' => [
            'login'    => TRUE,
            'register' => TRUE,
        ],
        
        // User validation
        'validation' => [
            'min_user_name_length'    => 4,
            'max_user_name_length'    => 50,
            'min_password_length'     => 6,
            'password_with_digit'     => TRUE, // digit required
            'password_with_lcc'       => TRUE, // lowercase character required
            'password_with_ucc'       => TRUE, // uppercase character required
            'password_with_nwc'       => TRUE, // non-word character required
            'allowed_user_name_chars' => str_split('abcdefghijklmnopqrstuvwxyz0123456789-_'),
        ],
        
        // Locale settings
        'locale' => [
            'process'     => \App\Utility\LanguageUtility::LOCALE_SESSION | \App\Utility\LanguageUtility::DOMAIN_DISABLED,
            'auto_detect' => TRUE,
            'code'        => 'en-US', // default / current language
            'active' => [
                'en-US' => 'imhh-slim.localhost',
                'de-DE' => 'de.imhh-slim.localhost',
            ],
        ],
    ],
];
