<?php
return [
    'settings' => [
        'determineRouteBeforeAppMiddleware' => true,
        'displayErrorDetails' => false, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header
        'public_path' => '/', // Relative to domain (e.g. project is in sub directory '/project/public/')
        'cache_path'  => __DIR__ . '/../cache/',
        'config_path'  => __DIR__ . '/../config/',

        // Renderer settings
        'renderer' => [
            'debug' => FALSE,
            'cache' => FALSE, // FALSE or path to cache folder '/../cache/'
            'template_path' => __DIR__ . '/../templates/',
        ],
        
        // Google recaptcha
        'recaptcha' => [
            'site'   => '',
            'secret' => '',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],
        
        // Locale settings
        'locale' => [
            'process' => \App\Utility\LanguageUtility::LOCALE_URL | \App\Utility\LanguageUtility::DOMAIN_DISABLED,
            'auto_detect' => TRUE,
            'default_domain' => 'slim3.insanitymeetshh.net',
            'code' => 'en-US', // default / current language
            'generic_code' => 'xx-XX', // routes which fits all localizations
            'path' => __DIR__ . '/../locale/',
            'active' => [
                'en-US' => 'slim3.insanitymeetshh.net',
                'de-DE' => 'slim3de.insanitymeetshh.net',
            ],
        ],
        
        // Doctrine settings
        'doctrine' => [
            'meta' => [
                'entity_path' => [
                    'src/Entity'
                ],
                'auto_generate_proxies' => true,
                'proxy_dir' =>  __DIR__.'/../cache/proxies',
                'cache' => null,
            ],
            'connection' => [
                'driver'   => 'pdo_mysql',
                'host'     => '127.0.0.1',
                'dbname'   => '',
                'user'     => '',
                'password' => '',
                'charset'  => 'utf8',
            ],
        ],
        
        // resources for acl
        'acl_resources' => [
            'create_user' => ['guest', 'admin', 'superadmin'],
            'edit_user' => ['member', 'admin', 'superadmin'], // edit own user information
            'show_user' => ['member', 'admin', 'superadmin'], // show own user information
            'delete_user' => ['member', 'admin', 'superadmin'], // delete own user
            'edit_user_other' => ['admin', 'superadmin'], // edit user information from other users
            'show_user_other' => ['guest', 'member', 'admin', 'superadmin'], // show user information from other users
            'delete_user_other' => ['superadmin'], // delete other users
            'create_role' => ['superadmin'],
            'edit_role' => ['superadmin'],  // edit role information
            'show_role' => ['admin', 'superadmin'],
            'delete_role' => ['superadmin'], // delete role
        ],
    ],
];
