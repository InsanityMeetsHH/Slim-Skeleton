<?php
namespace App\Controller;

use App\Entity\RecoveryCode;
use App\Utility\GeneralUtility;

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
            
            // if user exists
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
            [
                'user' => $user,
            ]
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
        return $this->view->render($response, 'user/login.html.twig', array_merge($args, []));
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
        unset($_SESSION['tempUser']);
        
        // if user exist
        if ($user instanceof \App\Entity\User) {
            // if password valid
            if (password_verify($request->getParam('user_pass'), $user->getPass())) {
                $_SESSION['tempUser'] = $user->getId();
                return $response->withRedirect($this->router->pathFor('user-two-factor-' . $this->currentLocale));
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
        return $this->view->render($response, 'user/login-success.html.twig', array_merge($args, []));
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
    
    /**
     * Enable Two Factor Action
     * 
     * @param \Slim\Http\Request $request
     * @param \Slim\Http\Response $response
     * @param array $args
     * @return \Slim\Http\Response
     */
    public function enableTwoFactor($request, $response, $args) {
        $user = $this->em->getRepository('App\Entity\User')->findOneBy(['id' => $this->currentUser]);
        $ga = new \PHPGangsta_GoogleAuthenticator();
        $secret = $user->getTwoFactorSecret();
        $passValid = FALSE;
        
        if ($user->hasTwoFactor()) {
            unset($_SESSION['pass_code']);
            return $response->withRedirect($this->router->pathFor('user-show-' . $this->currentLocale));
        }
        
        // if empty - generate new secret and update user
        if (empty($secret)) {
            // create unique secret
            do {
                $secret = $ga->createSecret();
                $userSecret = $this->em->getRepository('App\Entity\User')->findOneBy(['twoFactorSecret' => $secret]);
            } while ($userSecret instanceof \App\Entity\User);
            
            $user->setTwoFactorSecret($secret);
            $this->em->flush($user);
        }

        if ($request->isPost()) {
            $userPass = $request->getParam('user_pass');
            $passCode = $request->getParam('pass_code');
            
            if ($userPass !== NULL && $passCode === NULL && password_verify($userPass, $user->getPass())) {
                $passValid = TRUE;
                $_SESSION['pass_code'] = GeneralUtility::generateCode(6);
            } elseif (isset($_SESSION['pass_code']) && $_SESSION['pass_code'] === $passCode) {
                $passValid = TRUE;
                $code = $request->getParam('tf_code');
                $checkResult = $ga->verifyCode($secret, $code, 2); // 2 = 2*30sec clock tolerance
                
                if ($checkResult) {
                    $user->setTwoFactor(TRUE);
                    $this->em->flush($user);
                    unset($_SESSION['pass_code']);

                    // disable old recovery codes
                    $oldRecoveryCodes = $this->em->getRepository('App\Entity\RecoveryCode')->findBy(['user' => $this->currentUser]);
                    foreach ($oldRecoveryCodes as $oldRecoveryCode) {
                        $oldRecoveryCode->setDeleted(TRUE);
                        $this->em->remove($oldRecoveryCode);
                    }

                    // create unique recover codes
                    $countCodes = 0;
                    $recoveryCodes = [];
                    do {
                        $newRecoveryCode = GeneralUtility::generateCode();
                        $newEncryptRecoveryCode = GeneralUtility::encryptPassword($newRecoveryCode);
                        $recoveryCode = $this->em->getRepository('App\Entity\RecoveryCode')->findOneBy(['code' => $newEncryptRecoveryCode]);

                        if (!($recoveryCode instanceof \App\Entity\RecoveryCode)) {
                            $recoveryCode = new RecoveryCode();
                            $recoveryCode->setCode($newEncryptRecoveryCode)
                                    ->setUser($user);
                            $this->em->persist($recoveryCode);
                            $recoveryCodes[] = $newRecoveryCode;
                            $countCodes++;
                        }
                    } while ($countCodes < 5);

                    // save all changes
                    $this->em->flush();

                    return $this->view->render($response, 'user/recovery-codes.html.twig', array_merge($args, 
                        [
                            'recoveryCodes' => $recoveryCodes,
                        ]
                    ));
                }
            }
        }
        
        // Render view
        return $this->view->render($response, 'user/enable-two-factor.html.twig', array_merge($args, 
            [
                'secret' => $secret,
                'qr' => $ga->getQRCodeGoogleUrl($user->getName(), $secret, 'Slim Skeleton'),
                'passValid' => $passValid,
                'passCode' => isset($_SESSION['pass_code']) ? $_SESSION['pass_code'] : '',
            ]
        ));
    }
    
    /**
     * Two Factor Action
     * 
     * @param \Slim\Http\Request $request
     * @param \Slim\Http\Response $response
     * @param array $args
     * @return \Slim\Http\Response
     */
    public function twoFactor($request, $response, $args) {
        $user = $this->em->getRepository('App\Entity\User')->findOneBy(['id' => $_SESSION['tempUser']]);
        
        // if user exists
        if ($user instanceof \App\Entity\User) {
            $ga = new \PHPGangsta_GoogleAuthenticator();
            $secret = $user->getTwoFactorSecret();

            // if 2FA is disabled
            if (!$user->hasTwoFactor()) {
                $_SESSION['currentRole'] = $user->getRole()->getName();
                $_SESSION['currentUser'] = $user->getId();
                $this->logger->info("User " . $user->getId() . " logged in - UserController:twoFactor");
                return $response->withRedirect($this->router->pathFor('user-show-' . $this->currentLocale));
            }

            if ($request->isPost()) {
                $code = $request->getParam('tf_code');
                $checkResult = $ga->verifyCode($secret, $code, 2); // 2 = 2*30sec clock tolerance
                
                if ($checkResult === FALSE) {
                    $userRecoveryCodes = $this->em->getRepository('App\Entity\RecoveryCode')->findBy(['user' => $user->getId()]);
                    
                    if (is_array($userRecoveryCodes) && count($userRecoveryCodes) > 0) {
                        foreach ($userRecoveryCodes as $recoveryCode) {
                            if (password_verify($code, $recoveryCode->getCode())) {
                                $checkResult = TRUE;
//                                $recoveryCode->setDeleted(TRUE);
                                $this->em->remove($recoveryCode);
                                $this->em->flush();
                                break;
                            }
                        }
                    }
                }
                
                if ($checkResult) {
                    unset($_SESSION['tempUser']);
                    $_SESSION['currentRole'] = $user->getRole()->getName();
                    $_SESSION['currentUser'] = $user->getId();
                    $this->logger->info("User " . $user->getId() . " logged in - UserController:twoFactor");
                    return $response->withRedirect($this->router->pathFor('user-show-' . $this->currentLocale));
                }
            }
        } else {
            $this->logger->info("User '" . $_SESSION['tempUser'] . "' not found - UserController:twoFactor");
            return $response->withRedirect($this->router->pathFor('user-login-' . $this->currentLocale));
        }
        
        // Render view
        return $this->view->render($response, 'user/two-factor.html.twig', array_merge($args, []));
    }
}
