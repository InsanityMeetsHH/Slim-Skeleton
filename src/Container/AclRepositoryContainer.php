<?php
namespace App\Container;

use App\Utility\GeneralUtility;

/**
 * Description of AclRepository
 */
class AclRepositoryContainer {
    
    /**
     * @var \Geggleto\Acl\AclRepository 
     */
    private static $acl = null;

    /**
     * @param array $settings
     * @return \Geggleto\Acl\AclRepository
     */
    public static function getInstance() {
        return self::$acl;
    }

    /**
     * @param type $role
     * @param array $settings
     * @return \Geggleto\Acl\AclRepository
     */
    public static function setup() {
        $em = AppContainer::getInstance()->getContainer()->get('em');
        $settings = AppContainer::getInstance()->getContainer()->get('settings');
        $currentRole = GeneralUtility::getCurrentRole();
        GeneralUtility::setCurrentRole($currentRole);
        $roleNames = $allow = $deny = $allResources = [];
        
        try {
            $roles = $em->getRepository('App\Entity\Role')->findAll();
        } catch (\Exception $e) {
            // failed to connect
        }
        
        // if is array and not empty
        if (isset($roles) && is_array($roles) && !empty($roles)) {
            // loop through roles
            foreach ($roles as $roleKey => $role) {
                $roleName = $role->getName();
                $roleNames[] = $roleName;

                // initialize all resources from all active languages
                foreach ($settings['locale']['active'] as $activeLocale => $domain) {
                    // if translation file exists, load file to $locale
                    if (is_readable($settings['config_path'] . 'routes/' . $activeLocale . '.php')) {
                        $routes = require $settings['config_path'] . 'routes/' . $activeLocale . '.php';
                        
                        if (isset($routes) && is_array($routes)) {
                            foreach ($routes as $routeName => $route) {
                                // if route not in array
                                if (!in_array($route['route'], $allResources)) {
                                    $allResources[] = $route['route'];
                                }

                                // if route has rolesAllow and is array and current role is in rolesAllow
                                if (isset($route['rolesAllow']) && is_array($route['rolesAllow']) && in_array($roleName, $route['rolesAllow'])) {
                                    $allow[$roleName][] = $route['route'];
                                }

                                // if route has rolesDeny and is array and current role is in rolesDeny
                                if (isset($route['rolesDeny']) && is_array($route['rolesDeny']) && in_array($roleName, $route['rolesDeny'])) {
                                    $deny[$roleName][] = $route['route'];
                                }
                            }
                        }
                    }
                }
                
                if (isset($settings['acl_resources']) && is_array($settings['acl_resources'])) {
                    foreach ($settings['acl_resources'] as $aclResource => $aclRoles) {
                        // if is first role - add all resources
                        if ($roleKey === 0) {
                            $allResources[] = $aclResource;
                        }
                        
                        // if current role is in $aclRoles
                        if (in_array($roleName, $aclRoles)) {
                            $allow[$roleName][] = $aclResource;
                        }
                    }
                }
            }

            $aclSettings = [
                'resources' => $allResources,
                'roles' => $roleNames,
                'assignments' => [
                    'allow' => $allow,
                    'deny' => $deny,
                ]
            ];

            self::$acl = new \App\Repository\AclRepository([$currentRole], $aclSettings);
        }

        return self::$acl;
    }

    /**
     * deny clone
     */
    protected function __clone() {}

    /**
     * deny constructor
     */
    protected function __construct() {}
}
