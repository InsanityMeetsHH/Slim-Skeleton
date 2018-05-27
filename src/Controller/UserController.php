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
            
            // if user exist
            if ($user instanceof \App\Entity\User) {
                $this->logger->info("User '" . $args['name'] . "' found - UserController:show");
            } else {
                // if user not found
                $this->logger->info("User '" . $args['name'] . "' not found - UserController:show");
                return $response->withRedirect($this->router->pathFor('error-not-found-' . $this->currentLocale));
            }
        } elseif (!is_null($this->currentUser) && !isset($args['name']) && $this->aclRepository->isAllowed($this->currentRole, 'show_user')) {
            // if is logged in user and allowed show_user
            $user = $this->em->getRepository('App\Entity\User')->findOneBy(['id' => $this->currentUser]);
        } else {
            // if user is not logged in
            $this->logger->info("User not logged in - UserController:show");
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
        // Render view
        return $this->view->render($response, 'user/login.html.twig', array_merge($args, array()));
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
                $this->logger->info("User " . $user->getId() . " logged in - UserController:loginValidate");
                return $response->withRedirect($this->router->pathFor('user-login-success-' . $this->currentLocale));
            } else {
                $this->logger->info("User " . $user->getId() . " wrong password - UserController:loginValidate");
            }
        } else {
            $this->logger->info("User '" . $request->getParam('user_name') . "' not found - UserController:loginValidate");
        }
        
        // user or password not valid - redirect to login
        return $response->withRedirect($this->router->pathFor('user-login-' . $this->currentLocale));
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
        $this->logger->info("User " . $this->currentUser . " logged out - UserController:logout");
        return $response->withRedirect($this->router->pathFor('user-login-' . $this->currentLocale));
    }
}
