<?php
namespace App\Controller;

use App\Container\AppContainer;

/**
 * UserController is used for pages in context of user
 */
class UserController extends BaseController {
    /**
     * Login Action
     * 
     * @param \Slim\Http\Request $request
     * @param \Slim\Http\Response $response
     * @param array $args
     * @return \Slim\Http\Response
     */
    public function login($request, $response, $args) {
        // CSRF token name and value
        $nameKey = $this->csrf->getTokenNameKey();
        $valueKey = $this->csrf->getTokenValueKey();
        $name = $request->getAttribute($nameKey);
        $value = $request->getAttribute($valueKey);
        
        // Render index view
        return $this->view->render($response, 'login.html.twig', array_merge($args, 
            array(
                'nameKey' => $nameKey,
                'valueKey' => $valueKey,
                'name' => $name,
                'value' => $value,
            )
        ));
    }
    
    /**
     * Login Validate Action
     * 
     * @param \Slim\Http\Request $request
     * @param \Slim\Http\Response $response
     * @param array $args
     * @return static
     */
    public function loginValidate($request, $response, $args) {
        $user = $this->em->getRepository('App\Entity\User')->findOneByName($request->getParam('user_name'));
        
        // if user exists
        if ($user instanceof \App\Entity\User) {
            // if password valid
            if (password_verify($request->getParam('user_pass'), $user->getPass())) {
                $_SESSION['currentRole'] = 'member';
                return $response->withRedirect($this->router->pathFor('user-login-success-' . $this->currentLocale));
            } else {
                return $response->withRedirect($this->router->pathFor('user-login-' . $this->currentLocale));
            }
        } else {
            return $response->withRedirect($this->router->pathFor('user-login-' . $this->currentLocale));
        }
    }
    
    /**
     * Login Success Action
     * 
     * @param \Slim\Http\Request $request
     * @param \Slim\Http\Response $response
     * @param array $args
     * @return \Slim\Http\Response
     */
    public function loginSuccess($request, $response, $args) {
        
        // Render index view
        return $this->view->render($response, 'login-success.html.twig', array_merge($args, 
            array(
                
            )
        ));
    }
    
    /**
     * Login Success Action
     * 
     * @param \Slim\Http\Request $request
     * @param \Slim\Http\Response $response
     * @param array $args
     * @return \Slim\Http\Response
     */
    public function logout($request, $response, $args) {
        $_SESSION['currentRole'] = 'guest';
        return $response->withRedirect($this->router->pathFor('user-login-' . $this->currentLocale));
    }
}
