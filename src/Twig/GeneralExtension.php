<?php
namespace App\Twig;

use App\Utility\GeneralUtility;
use App\Utility\LanguageUtility;

/**
 * General Twig extension
 */
class GeneralExtension extends \Twig_Extension implements \Twig_Extension_GlobalsInterface
{

    /** @var array $settings **/
    protected $settings;
    
    public function __construct($container) {
        $this->settings = $container->get('settings');
    }

    public function getGlobals() {
        return [
            'settings' => $this->settings,
            'flashMessages' => GeneralUtility::getFlashMessages(),
            'localeProcess' => LanguageUtility::processHas(LanguageUtility::LOCALE_URL) ? 'url' : 'session',
        ];
    }

    public function getName() {
        return 'general_ext';
    }
}