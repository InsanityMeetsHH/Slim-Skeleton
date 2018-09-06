<?php
namespace App\Twig;

use App\Utility\LanguageUtility;

/**
 * Language twig extension
 */
class LanguageExtension extends \Twig_Extension {
    /**
     * @var \Slim\Container $container
     */
    private $container;

    public function __construct($container) {
        $this->container = $container;
    }

    public function getName() {
        return 'language_ext';
    }

    /**
     * Twig functions
     * 
     * @return array
     */
    public function getFunctions() {
        return [
            new \Twig_SimpleFunction('current_locale', [$this, 'currentLocale']),
            new \Twig_SimpleFunction('genericLanguage', [$this, 'genericLanguage']),
            new \Twig_SimpleFunction('langswitch', [$this, 'langSwitch']),
            new \Twig_SimpleFunction('language', [$this, 'language']),
            new \Twig_SimpleFunction('trans', [$this, 'trans']),
        ];
    }

    /**
     * Twig filters
     * 
     * @return array
     */
    public function getFilters() {
        return [
            new \Twig_SimpleFilter('trans', [$this, 'trans']),
        ];
    }
    
    /**
     * Get language switcher routes for current route
     * Sample: {{ langswitch() }}
     * 
     * @return array
     */
    public function langSwitch() {
        $settings = $this->container->get('settings');
        $currentRouteName = substr($_SESSION['route'], 0, strlen($_SESSION['route']) - 5);
        $langSwitch = [];
        
        foreach ($settings['locale']['active'] as $activeLocale => $domain) {
            // if translation file exists, load file to $locale
            if (is_readable($settings['locale']['path'] . $activeLocale . '.php') && $activeLocale != $settings['locale']['generic_code']) {
                $routeSuffix = $activeLocale;
                $locale = require $settings['locale']['path'] . $activeLocale . '.php';
                $routes = require $settings['config_path'] . 'routes-' . $activeLocale . '.php';
                $domain = $settings['locale']['active'][$activeLocale];
                
                if ($settings['locale']['use_domain'] && !isset($routes[rtrim($currentRouteName, '-')])) {
                    $routeSuffix = $settings['locale']['generic_code'];
                }
                
                $langSwitch[$currentRouteName . strtolower($activeLocale)] = [
                    'label' => $locale['langswitch-label'],
                    'image' => $locale['langswitch-image'],
                    'route' => $currentRouteName . strtolower($routeSuffix),
                    'current' => $domain === $_SERVER['SERVER_NAME'],
                    'domain' => $_SERVER['REQUEST_SCHEME'] . '://' . $domain,
                    'args' => $_SESSION['route-args'],
                ];
            }
        }
        
        return $langSwitch;
    }
    
    /**
     * Get current language-region combination
     * Sample: {{ language() }}
     * 
     * @return string
     */
    public function language() {
        $settings = $this->container->get('settings');
        return '-' . strtolower($settings['locale']['code']);
    }
    
    /**
     * Get generic language code
     * Sample: {{ genericLanguage() }}
     * 
     * @return string
     */
    public function genericLanguage() {
        $settings = $this->container->get('settings');
        return '-' . strtolower($settings['locale']['generic_code']);
    }

    /**
     * Get translation by translation key
     * See http://php.net/manual/de/function.sprintf.php to use $vars
     * Sample 1: {{ trans('lorem', {0: 'ipsum', 1: 'dollor'}) }}
     * Sample 2: {{ 'lorem'|trans({0: 'ipsum', 1: 'dollor'}) }}
     * 
     * @param string $key translation key
     * @param array $vars optional
     * @return string
     */
    public function trans($key, $vars = []) {
        return LanguageUtility::trans($key, $vars);
    }
    
    /**
     * Returns current locale.
     * Sample: {{ current_locale() }}
     * 
     * @return string
     */
    public function currentLocale() {
        return strtolower(LanguageUtility::getCurrentLocale());
    }
}