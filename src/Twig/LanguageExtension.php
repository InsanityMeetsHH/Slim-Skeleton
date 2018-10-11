<?php
namespace App\Twig;

use App\Utility\LanguageUtility;

/**
 * Language twig extension
 */
class LanguageExtension extends \Twig_Extension {
    
    /** * @var \Slim\Container $container */
    private $container;

    public function __construct($container, $router, $uri) {
        $this->container = $container;
        $this->router = $router;
        $this->uri = $uri;
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
            new \Twig_SimpleFunction('generic_locale', [$this, 'genericLocale']),
            new \Twig_SimpleFunction('is_current_locale_path', [$this, 'isCurrentLocalePath']),
            new \Twig_SimpleFunction('langswitch', [$this, 'langSwitch']),
            new \Twig_SimpleFunction('locale', [$this, 'locale']),
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
            if (is_readable($settings['locale']['path'] . $activeLocale . '.php')) {
                if ($activeLocale === $settings['locale']['generic_code']) {
                    continue;
                }
                
                $routeSuffix = $activeLocale;
                $locale = require $settings['locale']['path'] . $activeLocale . '.php';
                $routes = require $settings['config_path'] . 'routes/' . $activeLocale . '.php';
                $domain = $_SERVER['REQUEST_SCHEME'] . '://' . $settings['locale']['active'][$activeLocale];
                
                if (LanguageUtility::processHas(LanguageUtility::DOMAIN_ENABLED) && !isset($routes[rtrim($currentRouteName, '-')])) {
                    $routeSuffix = $settings['locale']['generic_code'];
                }
                
                if (LanguageUtility::processHas(LanguageUtility::DOMAIN_DISABLED)) {
                    $domain = '';
                    
                    if (LanguageUtility::processHas(LanguageUtility::LOCALE_SESSION)) {
                        $routeSuffix = $settings['locale']['generic_code'];
                    }
                }
                
                $langSwitch[$currentRouteName . strtolower($activeLocale)] = [
                    'label' => $locale['langswitch-label'],
                    'image' => $locale['langswitch-image'],
                    'route' => $currentRouteName . strtolower($routeSuffix),
                    'domain' => $domain,
                    'args' => $_SESSION['route-args'],
                    'locale' => $activeLocale,
                ];
            }
        }
        
        return $langSwitch;
    }
    
    /**
     * 
     * @param string $locale
     * @param string $name
     * @param array $data
     * @return boolean
     */
    public function isCurrentLocalePath($locale, $name, $data = []) {
        $result = FALSE;
        if (LanguageUtility::processHas(LanguageUtility::DOMAIN_ENABLED) 
                || (LanguageUtility::processHas(LanguageUtility::DOMAIN_DISABLED) && LanguageUtility::processHas(LanguageUtility::LOCALE_SESSION))) {
            if ($locale === LanguageUtility::getCurrentLocale()) {
                $result = TRUE;
            }
        } else {
            $result = $this->router->pathFor($name, $data) === $this->uri->getBasePath() . '/' . ltrim($this->uri->getPath(), '/');
        }
        
        return $result;
    }
    
    /**
     * Returns current language-region or generic code
     * Sample: {{ locale() }}
     * 
     * @return string
     */
    public function locale() {
        return LanguageUtility::getLocale();
    }
    
    /**
     * Returns generic language code
     * Sample: {{ generic_locale() }}
     * 
     * @return string
     */
    public function genericLocale() {
        return LanguageUtility::getGenericLocale();
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