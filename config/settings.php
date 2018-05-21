<?php
return [
    'settings' => [
        'determineRouteBeforeAppMiddleware' => true,
        'displayErrorDetails' => false, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],
        
        // Relative to domain (e.g. project is in sub directory '/project/public/')
        'public_path' => '/',
        
        // Cache settings
        'cache_path'  => __DIR__ . '/../cache/',
        
        // Locale settings
        'locale' => [
            'autoDetect' => TRUE,
            'code' => 'en-US', // default language
            'path' => __DIR__ . '/../locale/',
            'active' => [
                'de-DE',
                'en-US',
            ]
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
        'aclResources' => [
            'create_user' => ['guest', 'admin', 'superadmin'],
            'edit_user' => ['member', 'admin', 'superadmin'], // edit own user information
            'show_user' => ['member', 'admin', 'superadmin'], // show own user information
            'delete_user' => ['member', 'admin', 'superadmin'], // delete own user
            'edit_user_other' => ['admin', 'superadmin'], // edit user information from other users
            'show_user_other' => ['guest', 'member', 'admin', 'superadmin'], // show user information from other users
            'delete_user_other' => ['superadmin'], // delete own user
            'create_role' => ['superadmin'],
            'edit_role' => ['superadmin'],  // edit all roles
            'show_role' => ['admin', 'superadmin'],
            'delete_role' => ['superadmin'], // delete role
        ],
    ],
];
