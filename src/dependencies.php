<?php
// DIC configuration

$container = $app->getContainer();

// Flash Message
$container['flash'] = function () {
    return new \Slim\Flash\Messages();
};

// CSRF
$container['csrf'] = function ($c) {
    $guard = new \Slim\Csrf\Guard();
    $guard->setFailureCallable(function ($request, $response, $next) {
        $request = $request->withAttribute("csrf_status", false);
        return $next($request, $response);
    });
    return $guard;
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

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\RotatingFileHandler($settings['path'], 7, $settings['level']));
    return $logger;
};

//Override the default Not Found Handler
$container['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        $_SESSION['notFoundRoute'] = $request->getUri()->getPath();
        return $response->withRedirect($c->get('router')->pathFor('error-not-found-' . strtolower(\App\Utility\LanguageUtility::getCurrentLocale())));
    };
};

//Override the default Not Allowed Handler
$container['notAllowedHandler'] = function ($c) {
    return function ($request, $response, $methods) use ($c) {
        $_SESSION['allowedMethods'] = implode('-', $methods);
        $_SESSION['notAllowedMethod'] = $request->getMethod();
        $_SESSION['notAllowedRoute'] = $request->getUri()->getPath();
        return $response->withRedirect($c->get('router')->pathFor('error-not-allowed-' . strtolower(\App\Utility\LanguageUtility::getCurrentLocale())));
    };
};

// Register twig
$container['view'] = function ($c) {
    $settings = $c->get('settings');
    $view = new \Slim\Views\Twig($settings['renderer']['template_path'], [
        'cache' => $settings['renderer']['cache'],
        'debug' => $settings['renderer']['debug'],
    ]);
    
    // Instantiate and add Slim specific extension
    $router = $c->get('router');
    $uri = Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
    $view->addExtension(new Slim\Views\TwigExtension($router, $uri));
    $view->addExtension(new App\Twig\AclExtension($c));
    $view->addExtension(new App\Twig\CsrfExtension($c));
    $view->addExtension(new App\Twig\GeneralExtension($c));
    $view->addExtension(new App\Twig\LanguageExtension($c, $router, $uri));
    
    if ($settings['renderer']['debug']) {
        $view->addExtension(new Twig_Extension_Debug());
    }

    return $view;
};