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

    autoDetectBrowserLanguage($name, $arguments);
    return $next($request, $response);
});

// initialize all routes from all languages
foreach ($settings['settings']['locale']['active'] as $activeLocale) {
    // if translation file exists, load file to $locale
    if (is_readable($settings['settings']['locale']['path'] . $activeLocale . '.php')) {
        $tempLocale = require $settings['settings']['locale']['path'] . $activeLocale . '.php';
        $suffixName = '-' . strtolower($activeLocale);

        $app->get($tempLocale['page-example'], 'App\Controller\PageController:example')->setName('page-example' . $suffixName);
        $app->get($tempLocale['page-index'], 'App\Controller\PageController:index')->setName('page-index' . $suffixName);
    }
}

/**
 * @param array $a
 * @param array $b
 * @return boolean
 */
function localeQualityAsc($a, $b) {
    return $b['quality'] > $a['quality'];
}

/**
 * Detects browser languge and redirects to browser languge related page
 * 
 * @global array $settings
 * @global \Slim\App $app
 * @param string $routeName
 * @param array $routeArgs
 * @return type
 */
function autoDetectBrowserLanguage($routeName, $routeArgs) {
    global $settings, $app;
    
    // if server has HTTP_ACCEPT_LANGUAGE and autoDetect is active
    if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) 
            && is_string($_SERVER['HTTP_ACCEPT_LANGUAGE']) 
            && isset($settings['settings']['locale']['autoDetect'])
            && $settings['settings']['locale']['autoDetect'] === TRUE) {
        $browserLocales = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
        $localeQuality = array();

        // convert $_SERVER['HTTP_ACCEPT_LANGUAGE'] to array
        foreach ($browserLocales as $browserLocale) {
            $quality = 1;

            // if quality is defined 
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

        // locale with highest quality first
        usort($localeQuality, "localeQualityAsc");

        // if $localeQuality could decoded
        if (is_array($localeQuality) && count($localeQuality) > 0) {
            foreach ($settings['settings']['locale']['active'] as $activeLocale) {
                $locale = $localeQuality[0]['locale'];

                // locale has no '-' sign
                if (strpos($locale, '-') === FALSE) {
                    // add sign and region
                    $locale .= '-' . strtoupper($locale);
                }

                // if translation file exists, load file to $locale
                $autoDetectCookie = isset($_COOKIE['autoDetect']) ? (int)$_COOKIE['autoDetect'] : 0;
                if (is_readable($settings['settings']['locale']['path'] . $activeLocale . '.php') 
                        && $activeLocale === $locale && $autoDetectCookie !== 1) {
                    $suffixName = '-' . strtolower($activeLocale);
                    $newRouteName = substr($routeName, 0, -6) . $suffixName;
                    $compiledRoute = $app->getContainer()->get('router')->pathFor($newRouteName, $routeArgs);
                    
                    setcookie('autoDetect', 1, 0, '/');
                    // if browser language unlike current language 
                    if ($routeName !== $newRouteName) {
                        header('Location: ' . $compiledRoute);
                        exit;
                    }
                }
            }
        }
    }
}