<?php
// Detect localisation by REQUEST_URI

// if domain points to public dir
if ($settings['settings']['public_path'] == '/') {
    $uri = substr($_SERVER['REQUEST_URI'], 1, 3);
} else {
    // project is in sub dir
    $uri = substr(str_replace($settings['settings']['public_path'], '', $_SERVER['REQUEST_URI']), 0, 3);
}

switch ($uri) {
    // german
    case 'de/':
        $settings['settings']['locale']['code'] = 'de_DE';
        break;

    default:
        $settings['settings']['locale']['code'] = 'en_US';
        break;
}