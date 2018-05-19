<?php
namespace App\Container;

/**
 * Description of AclRepository
 */
class AclRepositoryContainer {
    
    /**
     * @var \Geggleto\Acl\AclRepository 
     */
    private static $aclRepository = null;

    /**
     * @param array $settings
     * @return \Geggleto\Acl\AclRepository
     */
    public static function getInstance() {
        return self::$aclRepository;
    }

    /**
     * @param type $role
     * @param array $settings
     * @return \Geggleto\Acl\AclRepository
     */
    public static function setup() {
        /** @var \Doctrine\ORM\EntityManager $em **/
        $em = AppContainer::getInstance()->getContainer()->get("em");
        $settings = AppContainer::getInstance()->getContainer()->get('settings');
        $currentRole = 'guest';
        $roles = $roleNames = $allow = $deny = $allResources = [];
        
        try {
            $roles = $em->getRepository('App\Entity\Role')->findAll();
            $currentRole = $roles[0]->getName();
        } catch (\Exception $e) {
            // failed to connect
        }

        if (isset($_SESSION['currentRole'])) {
            $currentRole = $_SESSION['currentRole'];
        } else {
            $_SESSION['currentRole'] = $currentRole;
        }
        
        // if is array and not empty
        if (is_array($roles) && !empty($roles)) {
            // loop through roles
            foreach ($roles as $roleKey => $role) {
                $roleName = $role->getName();
                $roleNames[] = $roleName;

                // initialize all resources from all active languages
                foreach ($settings['locale']['active'] as $activeLocale) {
                    // if translation file exists, load file to $locale
                    if (is_readable($settings['locale']['path'] . $activeLocale . '.php')) {
                        $locale = require $settings['locale']['path'] . $activeLocale . '.php';

                        if (isset($locale['routes']) && is_array($locale['routes'])) {
                            foreach ($locale['routes'] as $routeName => $route) {
                                // if is first role
                                if ($roleKey === 0) {
                                    $allResources[] = $route['route'];
                                }

                                if (isset($route['rolesAllow']) && is_array($route['rolesAllow']) && in_array($roleName, $route['rolesAllow'])) {
                                    $allow[$roleName][] = $route['route'];
                                }

                                if (isset($route['rolesDeny']) && is_array($route['rolesDeny']) && in_array($roleName, $route['rolesDeny'])) {
                                    $deny[$roleName][] = $route['route'];
                                }
                            }
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

            self::$aclRepository = new \App\Repository\AclRepository([$currentRole], $aclSettings);
        }

        return self::$aclRepository;
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
