<?php
namespace App\Utility;

use Geggleto\Acl\AclRepository;

/**
 * Description of AclUtility
 */
class AclUtility {
    /**
     * @var App\Utility\AclUtility
     */
    protected static $_instance = null;
    
    
    /**
     * @var Geggleto\Acl\AclRepository\AclRepository
     */
    protected static $_aclRepository;


    /**
     * @return App\Utility\AclUtility
     */
    public static function getInstance() {
        if (null === self::$_instance) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }
   
    /**
     * @param array $role
     * @param array $config
     * @return Geggleto\Acl\AclRepository\AclRepository
     */
    public static function setup(array $role, array $config = []) {
        self::$_instance = self::getInstance();
        self::$_aclRepository = new AclRepository($role, $config);

        return self::$_aclRepository;
    }
    
    /**
     * @return Geggleto\Acl\AclRepository\AclRepository
     */
    public static function getAclRepository() {
        return self::$_aclRepository;
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
