<?php
namespace App\Utility;

use App\Container\AppContainer;

class GeneralUtility {
    
    /**
     * @param string $pass
     * @return type
     */
    static function encryptPassword($pass) {
        $options = [
            'cost' => 11,
            'salt' => random_bytes(22),
        ];
        return password_hash($pass, PASSWORD_BCRYPT, $options);
    }
    
    /**
     * Generates random codes
     * 
     * @param integer $length
     * @return string
     */
    static function generateCode($length = 18) {
        $chars = 'abcdefghijkmnopqrstuvwxyz023456789';
        srand((double)microtime()*1000000);
        $i = 0;
        $code = '' ;

        while ($i <= $length) {
            $num = rand() % 33;
            $tmp = substr($chars, $num, 1);
            $code = $code . $tmp;
            $i++;
        }

        return $code;
    }
    
    /**
     * Returns current user id or NULL if user not logged in.
     * 
     * @return mixed
     */
    static function getCurrentUser() {
        return isset($_SESSION['currentUser']) ? $_SESSION['currentUser'] : NULL;
    }
    
    /**
     * Set the current user
     * 
     * @param integer $currentUser
     */
    static function setCurrentUser($currentUser) {
        $_SESSION['currentUser'] = $currentUser;
    }
    
    /**
     * Returns current role or 'guest' if user not logged in.
     * 
     * @return string
     */
    static function getCurrentRole() {
        return isset($_SESSION['currentRole']) ? $_SESSION['currentRole'] : 'guest';
    }
    
    /**
     * Set the current role
     * 
     * @param string $currentRole
     */
    static function setCurrentRole($currentRole) {
        $_SESSION['currentRole'] = $currentRole;
    }
    
    /**
     * Returns flash message array.
     * 
     * @return array
     */
    static function getFlashMessages() {
        $flash = AppContainer::getInstance()->getContainer()->get('flash');
        $flashMessages = $flash->getMessage('message');
        $messages = [];
        
        if (is_array($flashMessages)) {
            foreach ($flashMessages as $flashMessage) {
                list($text, $style) = explode(';', $flashMessage);
                $messages[] = [
                    'text' => $text,
                    'style' => $style,
                ];
            }
        }
        
        return $messages;
    }
    
    /**
     * Get real user ip
     * 
     * @return string
     */
    static function getUserIP() {
        // Get real visitor IP behind CloudFlare network
        if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
            $_SERVER['REMOTE_ADDR'] = $_SERVER['HTTP_CF_CONNECTING_IP'];
            $_SERVER['HTTP_CLIENT_IP'] = $_SERVER['HTTP_CF_CONNECTING_IP'];
        }
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];

        if (filter_var($client, FILTER_VALIDATE_IP)) {
            $ip = $client;
        } elseif(filter_var($forward, FILTER_VALIDATE_IP)) {
            $ip = $forward;
        } else {
            $ip = $remote;
        }

        return empty(explode(':', explode(',', $forward)[0])[0]) ? $ip : explode(':', explode(',', $forward)[0])[0];
    }
}
