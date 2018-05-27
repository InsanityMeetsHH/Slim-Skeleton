<?php
namespace App\Controller;

use App\Container\AclRepositoryContainer;
use App\Utility\LanguageUtility;

/**
 * Base functions for controller
 */
class BaseController {
    
    /** @var \Geggleto\Acl\AclRepository $aclRepository **/
    protected $aclRepository;
    
    /** @var \Doctrine\ORM\EntityManager $em **/
    protected $em;
    
    /** @var \Slim\Container $container **/
    protected $container;
    
    /** @var \Slim\Csrf\Guard $csrf **/
    protected $csrf;
    
    /** @var string $currentLocale **/
    protected $currentLocale;
    
    /** @var string $currentRole **/
    protected $currentRole;
    
    /** @var integer $currentUser **/
    protected $currentUser;
    
    /** @var \Monolog\Logger $logger **/
    protected $logger;
    
    /** @var \Slim\Router $router **/
    protected $router;
    
    /** @var \Slim\Views\Twig $view **/
    protected $view;

    /**
     * @param \Slim\Container $container
     */
    public function __construct($container) {
        $this->aclRepository = AclRepositoryContainer::getInstance();
        $this->em = $container->get("em");
        $this->container = $container;
        $this->csrf = $container->get("csrf");
        $this->currentLocale = strtolower(LanguageUtility::getCurrentLocale());
        $this->currentRole = isset($_SESSION['currentRole']) ? $_SESSION['currentRole'] : 'guest';
        $this->currentUser = isset($_SESSION['currentUser']) ? $_SESSION['currentUser'] : NULL;
        $this->logger = $container->get("logger");
        $this->router = $container->get("router");
        $this->view = $container->get("view");
    }
}
