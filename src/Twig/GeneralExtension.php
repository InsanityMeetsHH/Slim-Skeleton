<?php
namespace App\Twig;

use App\Utility\GeneralUtility;

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
        ];
    }

    public function getName() {
        return 'general_ext';
    }
}