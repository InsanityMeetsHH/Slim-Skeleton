<?php
if (!$settings['settings']['locale']['use_domain'] 
        && $settings['settings']['locale']['process'] === 'session') {
    if (isset($_COOKIE['current_locale'])) {
        $settings['settings']['locale']['code'] = $_COOKIE['current_locale'];
    } else {
        setcookie('current_locale', $settings['settings']['locale']['code'], 0, '/');
    }
} elseif ($settings['settings']['locale']['use_domain']) {
    $uri = $_SERVER['SERVER_NAME'];

    if (array_search($uri, $settings['settings']['locale']['active']) === FALSE) {
        $settings['settings']['locale']['code'] = 'en-US';
    } else {
        $settings['settings']['locale']['code'] = array_search($uri, $settings['settings']['locale']['active']);
    }
} else {
    // if domain points to public directory
    if ($settings['settings']['public_path'] == '/') {
        $uri = substr($_SERVER['REQUEST_URI'], 1, 6);
    } else {
        // project is in sub directory
        $uri = substr(str_replace($settings['settings']['public_path'], '', $_SERVER['REQUEST_URI']), 0, 6);
    }

    // if $uri contains not '-'
    if (strpos($uri, '-') == false) {
        // get the first 3 chars
        $uri = substr($uri, 0, 3);
    }
    
    switch ($uri) {
        // german
        case 'de/':
            $settings['settings']['locale']['code'] = 'de-DE';
            break;

        default:
            $settings['settings']['locale']['code'] = 'en-US';
            break;
    }
}