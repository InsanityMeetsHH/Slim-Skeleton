<?php
namespace App\Twig\Extension;

use App\Utility\LanguageUtility;

/**
 * General twig extension for this application
 */
class TwigExtension extends \Twig_Extension {
    /**
     * @var \Slim\Container $container
     */
    private $container;

    public function __construct($container) {
        $this->container = $container;
    }

    public function getName() {
        return 'app_ext';
    }

    /**
     * Twig functions
     * 
     * @return array
     */
    public function getFunctions() {
        return [
            new \Twig_SimpleFunction('langswitch', array($this, 'langSwitch')),
            new \Twig_SimpleFunction('language', array($this, 'language')),
            new \Twig_SimpleFunction('trans', array($this, 'trans')),
        ];
    }

    /**
     * Twig filters
     * 
     * @return array
     */
    public function getFilters() {
        return [
            new \Twig_SimpleFilter('trans', array($this, 'trans')),
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
        
        foreach ($settings['locale']['active'] as $activeLocale) {
            // if translation file exists, load file to $locale
            if (is_readable($settings['locale']['path'] . $activeLocale . '.php')) {
                $locale = require $settings['locale']['path'] . $activeLocale . '.php';
                
                $langSwitch[$currentRouteName . strtolower($activeLocale)] = array(
                    'label' => $locale['langswitch-label'],
                    'route' => $currentRouteName . strtolower($activeLocale),
                    'args' => $_SESSION['route-args'],
                );
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
        return '-' . substr($_SESSION['route'], -5);
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
}