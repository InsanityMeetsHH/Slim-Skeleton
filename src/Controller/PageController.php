<?php
namespace App\Controller;

use App\Entity\User;
use App\Utility\AclUtility;

/**
 * PageController is used for static pages
 */
class PageController extends BaseController {

    /**
     * Index Action
     * 
     * @param \Slim\Http\Request $request
     * @param \Slim\Http\Response $response
     * @param array $args
     * @return \Slim\Http\Response
     */
    public function index($request, $response, $args) {
        // Sample log message
        //$this->logger->info("Slim-Skeleton '/' route");
//        $acl = AclUtility::getInstance()::getAclRepository()->getAcl();
        
        $user = new User();
        $user->setName('harald4');
        $user->setPass('sjhdgfjs');
        $user->setRole($this->em->getRepository('App\Entity\Role')->findOneById(2));
//        $this->em->persist($user);
//        $this->em->flush();
        
        $demos = array();
        
        try {
            $demos = $this->em->getRepository('App\Entity\Demo')->findAll();
        } catch (\Exception $e) {
            // failed to connect
        }

        // Render index view
        return $this->view->render($response, 'index.html.twig', array_merge($args, 
            array(
                'demos' => $demos,
            )
        ));
    }

    /**
     * Example Action
     * 
     * @param \Slim\Http\Request $request
     * @param \Slim\Http\Response $response
     * @param array $args
     * @return \Slim\Http\Response
     */
    public function example($request, $response, $args) {
        // Render index view
        return $this->view->render($response, 'example.html.twig', $args);
    }
}
