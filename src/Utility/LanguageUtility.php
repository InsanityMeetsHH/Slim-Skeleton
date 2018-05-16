<?php
namespace App\Utility;

class LanguageUtility {

    /**
     * Get translation by translation key
     * See http://php.net/manual/de/function.sprintf.php to use $vars
     * 
     * @global array $settings
     * @param string $key translation key
     * @param array $vars optional
     * @return string
     */
    static function trans($key, $vars = []) {
        global $settings;
        
        // if translation file exists, load file to $locale
        if (is_readable($settings['settings']['locale']['path'] . $settings['settings']['locale']['code'] . '.php')) {
            $locale = require $settings['settings']['locale']['path'] . $settings['settings']['locale']['code'] . '.php';
        } else {
            // return translation key
            return $key;
        }
        
        // if translation exists, return translation
        if (isset($locale[$key])) {
            
            // $vars not empty and bigger than 0
            if (!empty($vars) && count($vars) > 0) {
                // replace placeholders in translation with $vars and return to frontend
                return vsprintf($locale[$key], $vars);
            }
            
            // return matching translation
            return $locale[$key];
        }
        
        // given key is not matching
        return $key;
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
    static function languageDetection($routeName, $routeArgs) {
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
            usort($localeQuality, array(LanguageUtility::class, 'localeQualityAsc'));

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

    /**
     * @param array $a
     * @param array $b
     * @return boolean
     */
    static function localeQualityAsc($a, $b) {
        return $b['quality'] > $a['quality'];
    }
    
    /**
     * Returns the current locale code
     * 
     * @global array $settings
     * @return array
     */
    static function getCurrentLocale() {
        global $settings;
        return $settings['settings']['locale']['code'];
    }
}
