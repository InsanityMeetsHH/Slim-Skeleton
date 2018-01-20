<?php

use Slim\Exception\NotFoundException;
use Slim\Http\Request;
use Slim\Http\Response;

// Routes
$app->add(function (Request $request, Response $response, callable $next) {
    $route = $request->getAttribute('route');

    // return NotFound for non existent route
    if (empty($route)) {
        throw new NotFoundException($request, $response);
    }

    $name = $route->getName();
//    $groups = $route->getGroups();
//    $methods = $route->getMethods();
    $arguments = $route->getArguments();
    
    // information for twig extension
    $_SESSION['route'] = $name;
    $_SESSION['route-args'] = $arguments;

    return $next($request, $response);
});

foreach ($settings['settings']['locale']['active'] as $activeLocale) {
    // if translation file exists, load file to $locale
    if (file_exists($settings['settings']['locale']['path'] . $activeLocale . '.php')) {
        $tempLocale = require $settings['settings']['locale']['path'] . $activeLocale . '.php';
        $suffixName = '-' . strtolower(substr($activeLocale, 0, 2));

        $app->get($tempLocale['page-example'], 'Vendor\Bundle\Controller\PageController:example')->setName('page-example' . $suffixName);
        $app->get($tempLocale['page-index'], 'Vendor\Bundle\Controller\PageController:index')->setName('page-index' . $suffixName);
    }
}