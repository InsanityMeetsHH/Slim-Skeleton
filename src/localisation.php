<?php
use App\Utility\LanguageUtility;

// if is domain mode or session mode
if ((($settings['settings']['locale']['process'] & LanguageUtility::DOMAIN_ENABLED) == LanguageUtility::DOMAIN_ENABLED 
    && ($settings['settings']['locale']['process'] & LanguageUtility::LOCALE_URL) == LanguageUtility::LOCALE_URL) 
    || (($settings['settings']['locale']['process'] & LanguageUtility::DOMAIN_DISABLED) == LanguageUtility::DOMAIN_DISABLED 
        && ($settings['settings']['locale']['process'] & LanguageUtility::LOCALE_SESSION) == LanguageUtility::LOCALE_SESSION)) {
    $settings['settings']['locale']['active'][$settings['settings']['locale']['generic_code']] = '';
}

// if is session mode
if (($settings['settings']['locale']['process'] & LanguageUtility::DOMAIN_DISABLED) == LanguageUtility::DOMAIN_DISABLED 
        && ($settings['settings']['locale']['process'] & LanguageUtility::LOCALE_SESSION) == LanguageUtility::LOCALE_SESSION) {
    if (isset($_COOKIE['current_locale'])) {
        $settings['settings']['locale']['code'] = $_COOKIE['current_locale'];
    } else {
        setcookie('current_locale', $settings['settings']['locale']['code'], 0, '/');
    }
// if is domain mode
} elseif (($settings['settings']['locale']['process'] & LanguageUtility::DOMAIN_ENABLED) == LanguageUtility::DOMAIN_ENABLED 
        && ($settings['settings']['locale']['process'] & LanguageUtility::LOCALE_URL) == LanguageUtility::LOCALE_URL) {
    $uri = $_SERVER['SERVER_NAME'];

    if (array_search($uri, $settings['settings']['locale']['active']) === FALSE) {
        die("Domain '$uri' was not found in \$settings['locale']['active']");
    } else {
        $settings['settings']['locale']['code'] = array_search($uri, $settings['settings']['locale']['active']);
    }
// if is path segment mode
} elseif (($settings['settings']['locale']['process'] & LanguageUtility::DOMAIN_DISABLED) == LanguageUtility::DOMAIN_DISABLED 
        && ($settings['settings']['locale']['process'] & LanguageUtility::LOCALE_URL) == LanguageUtility::LOCALE_URL) {
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
} else {
    die("Locale process setting not allowed in \$settings['locale']['process']");
}