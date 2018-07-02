<?php
namespace App\Twig;

use App\Container\AclRepositoryContainer;
use App\Utility\LanguageUtility;

/**
 * General twig extension for this application
 */
class AppExtension extends \Twig_Extension {
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
            new \Twig_SimpleFunction('has_role', [$this, 'hasRole']),
            new \Twig_SimpleFunction('is_allowed', [$this, 'isAllowed']),
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
        
        foreach ($settings['locale']['active'] as $activeLocale) {
            // if translation file exists, load file to $locale
            if (is_readable($settings['locale']['path'] . $activeLocale . '.php')) {
                $locale = require $settings['locale']['path'] . $activeLocale . '.php';
                
                $langSwitch[$currentRouteName . strtolower($activeLocale)] = [
                    'label' => $locale['langswitch-label'],
                    'image' => $locale['langswitch-image'],
                    'route' => $currentRouteName . strtolower($activeLocale),
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
    
    /**
     * Checks if given role is current role
     * 
     * @param array|string $role
     * @return bool
     */
    public function hasRole($role) {
        if (is_string($role) && isset($_SESSION['currentRole']) && $_SESSION['currentRole'] === $role) {
            return TRUE;
        }
        
        if (is_array($role) && isset($_SESSION['currentRole']) && in_array($_SESSION['currentRole'], $role)) {
            return TRUE;
        }
        
        return FALSE;
    }
    
    /**
     * Checks if given resource is allowed by current role
     * 
     * @param string $resource
     * @return bool
     */
    public function isAllowed($resource) {
        $aclRepository = AclRepositoryContainer::getInstance();
        
        if (is_string($resource) && isset($_SESSION['currentRole']) && $aclRepository->isAllowed($_SESSION['currentRole'], $resource)) {
            return TRUE;
        }
        
        return FALSE;
    }
}