<?php
namespace App\Controller;

use App\Entity\RecoveryCode;
use App\Entity\User;
use App\Utility\GeneralUtility;
use App\Utility\LanguageUtility;

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
    public function showAction($request, $response, $args) {
        // if is other user and current user is alowed show_user_other
        if (isset($args['name']) && $this->acl->isAllowed($this->currentRole, 'show_user_other')) {
            $user = $this->em->getRepository('App\Entity\User')->findOneBy(['name' => $args['name'], 'hidden' => 0]);
            
            // if user exists
            if ($user instanceof User) {
                $this->logger->info("User '" . $args['name'] . "' found - UserController:show");
            } else {
                // if user not found
                $this->logger->info("User '" . $args['name'] . "' not found - UserController:show");
                return $response->withRedirect($this->router->pathFor('error-not-found-' . LanguageUtility::getGenericLocale()));
            }
        } elseif (!is_null($this->currentUser) && !isset($args['name']) && $this->acl->isAllowed($this->currentRole, 'show_user')) {
            // if is logged in user and allowed show_user
            $user = $this->em->getRepository('App\Entity\User')->findOneBy(['id' => $this->currentUser]);
        } else {
            // if user is not logged in
            $this->logger->info("User not logged in - UserController:show");
            return $response->withRedirect($this->router->pathFor('user-login-' . LanguageUtility::getGenericLocale()));
        }
        
        // Render view
        return $this->view->render($response, 'user/show.html.twig', array_merge($args, [
            'user' => $user,
        ]));
    }
    
    /**
     * Shows registration form
     * 
     * @param \Slim\Http\Request $request
     * @param \Slim\Http\Response $response
     * @param array $args
     * @return \Slim\Http\Response
     */
    public function registerAction($request, $response, $args) {
        if ($this->settings['active_pages']['register'] === FALSE && $this->currentRole !== 'superadmin') {
            return $this->view->render($response, 'partials/construction.html.twig', array_merge($args, []));
        }
        
        // Render view
        return $this->view->render($response, 'user/register.html.twig', array_merge($args, []));
    }
    
    /**
     * Saves data from registration form
     * 
     * @param \Slim\Http\Request $request
     * @param \Slim\Http\Response $response
     * @param array $args
     * @return \Slim\Http\Response
     */
    public function saveRegisterAction($request, $response, $args) {
        if ($this->settings['active_pages']['register'] === FALSE && $this->currentRole !== 'superadmin') {
            return $response->withRedirect($this->router->pathFor('page-index-' . LanguageUtility::getGenericLocale()));
        }
        $rcRespSuccess = TRUE;
        
        if (isset($this->settings['recaptcha']['secret']) && strlen($this->settings['recaptcha']['secret']) > 20) {
            $recaptcha = new \ReCaptcha\ReCaptcha($this->settings['recaptcha']['secret']);
            $resp = $recaptcha->setExpectedHostname($_SERVER['SERVER_NAME'])
                ->verify($request->getParam('g-recaptcha-response'), GeneralUtility::getUserIP());
            $rcRespSuccess = $resp->isSuccess();
        }
        
        if ($rcRespSuccess || isset($_ENV['docker'])) {
            // if validation passed
            if (GeneralUtility::validateUser($request)) {
                $this->flash->addMessage('message', LanguageUtility::trans('register-flash-m5') . ';' . self::STYLE_SUCCESS);

                $user = new User();
                $user->setName($request->getParam('user_name'))
                    ->setRole($this->em->getRepository('App\Entity\Role')->findOneBy(['name' => 'member']))
                    ->setPass($request->getParam('user_pass'));
                $this->em->persist($user);
                $this->em->flush();
                
                return $response->withRedirect($this->router->pathFor('user-login-' . LanguageUtility::getGenericLocale()));
            }
        } else {
            $this->flash->addMessage('message', LanguageUtility::trans('register-flash-m6') . ';' . self::STYLE_DANGER);
        }
        
        return $response->withRedirect($this->router->pathFor('user-register-' . LanguageUtility::getLocale()));
    }
    
    /**
     * Shows login form
     * 
     * @param \Slim\Http\Request $request
     * @param \Slim\Http\Response $response
     * @param array $args
     * @return \Slim\Http\Response
     */
    public function loginAction($request, $response, $args) {
        if ($this->settings['active_pages']['login'] === FALSE && $this->currentRole !== 'superadmin') {
            return $this->view->render($response, 'partials/construction.html.twig', array_merge($args, []));
        }
        
        // Render view
        return $this->view->render($response, 'user/login.html.twig', array_merge($args, []));
    }
    
    /**
     * Validates data from login form
     * 
     * @param \Slim\Http\Request $request
     * @param \Slim\Http\Response $response
     * @param array $args
     * @return static
     */
    public function loginValidateAction($request, $response, $args) {
        if ($this->settings['active_pages']['login'] === FALSE && $this->currentRole !== 'superadmin') {
            return $response->withRedirect($this->router->pathFor('page-index-' . LanguageUtility::getGenericLocale()));
        }
        
        $user = $this->em->getRepository('App\Entity\User')->findOneBy(['name' => $request->getParam('user_name'), 'hidden' => 0]);
        unset($_SESSION['tempUser']);
        
        // if user exists
        if ($user instanceof User) {
            // if password valid
            if (password_verify($request->getParam('user_pass'), $user->getPass())) {
                $_SESSION['tempUser'] = $user->getId();
                return $response->withRedirect($this->router->pathFor('user-two-factor-' . LanguageUtility::getLocale()));
            } else {
                $this->logger->info("User " . $user->getId() . " wrong password - UserController:loginValidate");
            }
        } else {
            $this->logger->info("User '" . $request->getParam('user_name') . "' not found - UserController:loginValidate");
        }
        
        // user or password not valid - redirect to login
        return $response->withRedirect($this->router->pathFor('user-login-' . LanguageUtility::getGenericLocale()));
    }
    
    /**
     * Login Success Action
     * 
     * @param \Slim\Http\Request $request
     * @param \Slim\Http\Response $response
     * @param array $args
     * @return \Slim\Http\Response
     */
    public function loginSuccessAction($request, $response, $args) {
        // Render view
        return $this->view->render($response, 'user/login-success.html.twig', array_merge($args, []));
    }
    
    /**
     * Logout user from system
     * 
     * @param \Slim\Http\Request $request
     * @param \Slim\Http\Response $response
     * @param array $args
     * @return \Slim\Http\Response
     */
    public function logoutAction($request, $response, $args) {
        GeneralUtility::setCurrentRole('guest');
        GeneralUtility::setCurrentUser(NULL);
        $this->logger->info("User " . $this->currentUser . " logged out - UserController:logout");
        return $response->withRedirect($this->router->pathFor('page-index-' . LanguageUtility::getGenericLocale()));
    }
    
    /**
     * Enables 2FA and generates recovery codes
     * 
     * @param \Slim\Http\Request $request
     * @param \Slim\Http\Response $response
     * @param array $args
     * @return \Slim\Http\Response
     */
    public function enableTwoFactorAction($request, $response, $args) {
        $user = $this->em->getRepository('App\Entity\User')->findOneBy(['id' => $this->currentUser]);
        $ga = new \PHPGangsta_GoogleAuthenticator();
        $secret = $user->getTwoFactorSecret();
        $passValid = FALSE;
        
        // if user has 2FA enabled
        if ($user->hasTwoFactor()) {
            unset($_SESSION['pass_code']);
            return $response->withRedirect($this->router->pathFor('user-show-' . LanguageUtility::getLocale(), ['name' => $user->getName()]));
        }
        
        // if empty - generate new secret and update user
        if (empty($secret)) {
            // create unique secret
            do {
                $secret = $ga->createSecret();
                $userSecret = $this->em->getRepository('App\Entity\User')->findOneBy(['twoFactorSecret' => $secret]);
            } while ($userSecret instanceof User);
            
            $user->setTwoFactorSecret($secret);
            $this->em->flush($user);
        }

        if ($request->isPost()) {
            $userPass = $request->getParam('user_pass');
            $passCode = $request->getParam('pass_code');
            
            // if password is valid
            if ($userPass !== NULL && $passCode === NULL && password_verify($userPass, $user->getPass())) {
                // set temporary values
                $passValid = TRUE;
                $_SESSION['pass_code'] = GeneralUtility::generateCode(6);
            } elseif (isset($_SESSION['pass_code']) && $_SESSION['pass_code'] === $passCode) {
                // if temporary pass_code valid
                $passValid = TRUE;
                $code = $request->getParam('tf_code');
                $checkResult = $ga->verifyCode($secret, $code, 2); // 2 = 2*30sec clock tolerance
                
                // if two factor is valid
                if ($checkResult) {
                    $user->setTwoFactor(TRUE);
                    $this->em->flush($user);
                    unset($_SESSION['pass_code']);

                    // disable old recovery codes
                    $oldRecoveryCodes = $this->em->getRepository('App\Entity\RecoveryCode')->findBy(['user' => $this->currentUser]);
                    foreach ($oldRecoveryCodes as $oldRecoveryCode) {
                        $this->em->remove($oldRecoveryCode);
                    }

                    // create unique recover codes
                    $countCodes = 0;
                    $recoveryCodes = [];
                    do {
                        $newRecoveryCode = GeneralUtility::generateCode();
                        $newEncryptRecoveryCode = GeneralUtility::encryptPassword($newRecoveryCode);
                        $recoveryCode = $this->em->getRepository('App\Entity\RecoveryCode')->findOneBy(['code' => $newEncryptRecoveryCode]);
                        
                        // if recovery code not exists
                        if ($recoveryCode === NULL) {
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
                    $this->flash->addMessage('message', LanguageUtility::trans('2fa-enabled') . ';' . self::STYLE_SUCCESS);

                    return $this->view->render($response, 'user/recovery-codes.html.twig', array_merge($args, [
                        'recoveryCodes' => $recoveryCodes,
                    ]));
                }
            }
        }
        
        // Render view
        return $this->view->render($response, 'user/enable-two-factor.html.twig', array_merge($args, [
            'secret' => $secret,
            'qr' => $ga->getQRCodeGoogleUrl($user->getName(), $secret, $this->settings['2fa_qrc_title']),
            'passValid' => $passValid,
            'passCode' => isset($_SESSION['pass_code']) ? $_SESSION['pass_code'] : '',
        ]));
    }
    
    /**
     * Shows 2FA form validates data
     * 
     * @param \Slim\Http\Request $request
     * @param \Slim\Http\Response $response
     * @param array $args
     * @return \Slim\Http\Response
     */
    public function twoFactorAction($request, $response, $args) {
        $user = $this->em->getRepository('App\Entity\User')->findOneBy(['id' => $_SESSION['tempUser']]);
        
        // if user exists
        if ($user instanceof User) {
            $ga = new \PHPGangsta_GoogleAuthenticator();
            $secret = $user->getTwoFactorSecret();

            // if 2FA is disabled
            if (!$user->hasTwoFactor()) {
                GeneralUtility::setCurrentRole($user->getRole()->getName());
                GeneralUtility::setCurrentUser($user->getId());
                $this->logger->info("User " . $user->getId() . " logged in - UserController:twoFactor");
                return $response->withRedirect($this->router->pathFor('user-show-' . LanguageUtility::getLocale(), ['name' => $user->getName()]));
            }

            if ($request->isPost()) {
                $code = $request->getParam('tf_code');
                $checkResult = $ga->verifyCode($secret, $code, 2); // 2 = 2*30sec clock tolerance
                
                // if two factor is not valid
                if ($checkResult === FALSE) {
                    $userRecoveryCodes = $this->em->getRepository('App\Entity\RecoveryCode')->findBy(['user' => $user->getId()]);
                    
                    // if user has recovery codes
                    if (is_array($userRecoveryCodes) && count($userRecoveryCodes) > 0) {
                        foreach ($userRecoveryCodes as $recoveryCode) {
                            // if $code is a recovery code
                            if (password_verify($code, $recoveryCode->getCode())) {
                                $checkResult = TRUE;
                                $this->em->remove($recoveryCode);
                                $this->em->flush();
                                break;
                            }
                        }
                    }
                }
                
                // if two factor is valid
                if ($checkResult) {
                    unset($_SESSION['tempUser']);
                    GeneralUtility::setCurrentRole($user->getRole()->getName());
                    GeneralUtility::setCurrentUser($user->getId());
                    $this->logger->info("User " . $user->getId() . " logged in - UserController:twoFactor");
                    return $response->withRedirect($this->router->pathFor('user-show-' . LanguageUtility::getLocale(), ['name' => $user->getName()]));
                }
            }
        } else {
            $this->logger->info("User '" . $_SESSION['tempUser'] . "' not found - UserController:twoFactor");
            return $response->withRedirect($this->router->pathFor('user-login-' . LanguageUtility::getGenericLocale()));
        }
        
        // Render view
        return $this->view->render($response, 'user/two-factor.html.twig', array_merge($args, []));
    }
}
