<?php
namespace App\Container;

/**
 * Description of App
 */
class AppContainer {
    
    /**
     * @var \Slim\App 
     */
    private static $app = null;

    /**
     * 
     * @param array $settings
     * @return \Slim\App
     */
    public static function getInstance($settings = []) {
        if (null === self::$app) {
            self::$app = self::makeInstance($settings);
        }

        return self::$app;
    }

    /**
     * @param array $settings
     * @return \Slim\App
     */
    private static function makeInstance($settings = []) {
        $app = new \Slim\App($settings);
        // do all logic for adding routes etc

        return $app;
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
