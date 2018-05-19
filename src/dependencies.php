<?php
// DIC configuration

$container = $app->getContainer();

// Register twig
$container['view'] = function ($c) {
    $settings = $c->get('settings');
    $view = new \Slim\Views\Twig($settings['renderer']['template_path'], [
        'cache' => FALSE
//        'cache' => $settings['cache_path']
    ]);
    
    // Instantiate and add Slim specific extension
    $router = $c->get('router');
    $uri = Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
    $view->addExtension(new Slim\Views\TwigExtension($router, $uri));
    $view->addExtension(new App\Twig\Extension\TwigExtension($c));

    return $view;
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

// Doctrine
$container['em'] = function ($c) {
    $settings = $c->get('settings');
    $config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(
        $settings['doctrine']['meta']['entity_path'],
        $settings['doctrine']['meta']['auto_generate_proxies'],
        $settings['doctrine']['meta']['proxy_dir'],
        $settings['doctrine']['meta']['cache'],
        false
    );
    return \Doctrine\ORM\EntityManager::create($settings['doctrine']['connection'], $config);
};

// CSRF
$container['csrf'] = function ($c) {
    return new \Slim\Csrf\Guard;
};

//Override the default Not Found Handler
$c['notFoundHandler'] = function ($c) {
    return 'App\Controller\ErrorController:notFound';
};

//Override the default Not Allowed Handler
$c['notAllowedHandler'] = function ($c) {
    return 'App\Controller\ErrorController:notAllowed';
};