<?php
// Detect localisation by REQUEST_URI

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