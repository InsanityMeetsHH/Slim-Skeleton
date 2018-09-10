<?php
namespace App\Twig;

use App\Container\AclRepositoryContainer;
use App\Utility\GeneralUtility;

/**
 * ACL twig extension
 */
class AclExtension extends \Twig_Extension {
    /** @var \Slim\Container $container */
    private $container;

    public function __construct($container) {
        $this->container = $container;
    }

    public function getName() {
        return 'acl_ext';
    }

    /**
     * Twig functions
     * 
     * @return array
     */
    public function getFunctions() {
        return [
            new \Twig_SimpleFunction('current_user', [$this, 'currentUser']),
            new \Twig_SimpleFunction('current_role', [$this, 'currentRole']),
            new \Twig_SimpleFunction('is_allowed', [$this, 'isAllowed']),
            new \Twig_SimpleFunction('has_role', [$this, 'hasRole']),
        ];
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
    
    /**
     * Returns current user id or NULL if user not logged in.
     * Sample: {{ current_user() }}
     * 
     * @return mixed
     */
    public function currentUser() {
        return GeneralUtility::getCurrentUser();
    }
    
    /**
     * Returns current role or 'guest' if user not logged in.
     * Sample: {{ current_role() }}
     * 
     * @return mixed
     */
    public function currentRole() {
        return GeneralUtility::getCurrentRole();
    }
}