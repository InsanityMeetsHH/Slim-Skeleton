<?php
namespace App\Twig;

use App\Utility\GeneralUtility;
use App\Utility\LanguageUtility;

/**
 * General Twig extension
 */
class GeneralExtension extends \Twig_Extension implements \Twig_Extension_GlobalsInterface {

    /** @var array $settings **/
    protected $settings;
    
    /** @var \Doctrine\ORM\EntityManager $em **/
    protected $em;
    
    public function __construct($container) {
        $this->settings = $container->get('settings');
        $this->em = $container->get('em');
    }

    public function getGlobals() {
        return [
            'settings' => $this->settings,
            'currentUser' => $this->em->getRepository('App\Entity\User')->findOneBy(['id' => GeneralUtility::getCurrentUser(), 'hidden' => 0]),
            'flashMessages' => GeneralUtility::getFlashMessages(),
            'localeProcess' => LanguageUtility::processHas(LanguageUtility::LOCALE_URL) ? 'url' : 'session',
        ];
    }

    public function getName() {
        return 'general_ext';
    }
}