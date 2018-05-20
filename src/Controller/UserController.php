<?php
namespace App\Controller;

/**
 * UserController is used for pages in context of user
 */
class UserController extends BaseController {
    
    /**
     * Show Action
     * 
     * @param \Slim\Http\Request $request
     * @param \Slim\Http\Response $response
     * @param array $args
     * @return \Slim\Http\Response
     */
    public function show($request, $response, $args) {
        // if is other user and current user is alowed show_user_other
        if (isset($args['name']) && $this->aclRepository->isAllowed($this->currentRole, 'show_user_other')) {
            $user = $this->em->getRepository('App\Entity\User')->findOneBy(['name' => $args['name'], 'deleted' => 0]);
            
            // if user not found
            if (!($user instanceof \App\Entity\User)) {
                return $response->withRedirect($this->router->pathFor('error-not-found-' . $this->currentLocale));
            }
        } elseif (isset($_SESSION['currentUser']) && !isset($args['name']) && $this->aclRepository->isAllowed($this->currentRole, 'show_user')) {
            // if is logged in user and allowed show_user
            $user = $this->em->getRepository('App\Entity\User')->findOneBy(['id' => $this->currentUser, 'deleted' => 0]);
        } else {
            // if user is not logged in
            return $response->withRedirect($this->router->pathFor('user-login-' . $this->currentLocale));
        }
        
        // Render view
        return $this->view->render($response, 'user/show.html.twig', array_merge($args, 
            array(
                'user' => $user,
            )
        ));
    }
    
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
        
        // Render view
        return $this->view->render($response, 'user/login.html.twig', array_merge($args, 
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
        $user = $this->em->getRepository('App\Entity\User')->findOneBy(['name' => $request->getParam('user_name'), 'deleted' => 0]);
        
        // if user exists
        if ($user instanceof \App\Entity\User) {
            // if password valid
            if (password_verify($request->getParam('user_pass'), $user->getPass())) {
                $_SESSION['currentRole'] = $user->getRole()->getName();
                $_SESSION['currentUser'] = $user->getId();
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
        // Render view
        return $this->view->render($response, 'user/login-success.html.twig', array_merge($args, array()));
    }
    
    /**
     * Logout Action
     * 
     * @param \Slim\Http\Request $request
     * @param \Slim\Http\Response $response
     * @param array $args
     * @return \Slim\Http\Response
     */
    public function logout($request, $response, $args) {
        $_SESSION['currentRole'] = 'guest';
        unset($_SESSION['currentUser']);
        return $response->withRedirect($this->router->pathFor('user-login-' . $this->currentLocale));
    }
}
