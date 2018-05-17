<?php
namespace App\Controller;

use App\Utility\LanguageUtility;

/**
 * Base functions for controller
 */
class BaseController {
    
    /** @var \Doctrine\ORM\EntityManager $em **/
    protected $em;
    
    /** @var \Slim\Container $container **/
    protected $container;
    
    /** @var \Slim\Csrf\Guard $csrf **/
    protected $csrf;
    
    /** @var string $currentLocale **/
    protected $currentLocale;
    
    /** @var \Slim\Router $router **/
    protected $router;
    
    /** @var \Slim\Views\Twig $view **/
    protected $view;

    /**
     * @param \Slim\Container $container
     */
    public function __construct($container) {
        $this->em = $container->get("em");
        $this->container = $container;
        $this->csrf = $container->get("csrf");
        $this->currentLocale = strtolower(LanguageUtility::getCurrentLocale());
        $this->router = $container->get("router");
        $this->view = $container->get("view");
    }
}
