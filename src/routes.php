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
    if (is_readable($settings['settings']['locale']['path'] . $activeLocale . '.php')) {
        $tempLocale = require $settings['settings']['locale']['path'] . $activeLocale . '.php';
        $suffixName = '-' . strtolower($activeLocale);

        $app->get($tempLocale['page-example'], 'App\Controller\PageController:example')->setName('page-example' . $suffixName);
        $app->get($tempLocale['page-index'], 'App\Controller\PageController:index')->setName('page-index' . $suffixName);
    }
}

// auto detect browser language
//var_dump($_SERVER['HTTP_ACCEPT_LANGUAGE']);
function cmpLocaleQuality($a, $b) {
    return $b['quality'] > $a['quality'];
}

if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) 
        && is_string($_SERVER['HTTP_ACCEPT_LANGUAGE']) 
        && isset($settings['settings']['locale']['autoDetect'])
        && $settings['settings']['locale']['autoDetect'] === TRUE) {
    $browserLocales = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
    $localeQuality = array();
    
    foreach ($browserLocales as $browserLocale) {
        $quality = 1;
        
        if (strpos($browserLocale, 'q=')) {
            list($locale, $quality) = explode(';', $browserLocale);
            
            $quality = floatval(str_replace('q=', '', $quality));
        } else {
            $locale = $browserLocale;
        }
        
        $localeQuality[] = array(
            'locale' => $locale,
            'quality' => $quality,
        );
    }

    usort($localeQuality, "cmpLocaleQuality");
    
//    echo '<pre>';
//    print_r($localeQuality);
//    echo '</pre>';
    
    if (is_array($localeQuality) && count($localeQuality) > 0) {
        foreach ($settings['settings']['locale']['active'] as $activeLocale) {
            $locale = $localeQuality[0]['locale'];
            
            if (strpos($locale, '-') === FALSE) {
                $locale .= '-' . strtoupper($locale);
            }
            
            // if translation file exists, load file to $locale
            $autoDetectCookie = isset($_COOKIE['autoDetect']) ? (int)$_COOKIE['autoDetect'] : 0;
            if (is_readable($settings['settings']['locale']['path'] . $activeLocale . '.php') 
                    && $activeLocale === $locale 
                    && $autoDetectCookie !== 1) {
//                $tempLocale = require $settings['settings']['locale']['path'] . $activeLocale . '.php';
//                setcookie('autoDetect', 1, 0, '/');
//                $suffixName = '-' . strtolower($activeLocale);
//                echo $tempLocale['page-index'];
//                $app->redirect($app->pathFor('page-index' . $suffixName));
//                header('Location: ' . $tempLocale['page-index']);
//                echo 'route name ' . $_COOKIE['routeName'];
            }
        }
    }
}