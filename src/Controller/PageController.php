<?php
namespace Vendor\Bundle\Controller;

/**
 * Description of PageController
 */
class PageController {
    
    /** @var \Slim\Container $container **/
    protected $container;
    
    /** @var \Doctrine\ORM\EntityManager $em **/
    protected $em;
    
    /** @var \Slim\Views\Twig $view **/
    protected $view;

    /**
     * @param \Slim\Container $container
     */
    public function __construct($container) {
        $this->container = $container;
        $this->em = $container->get("em");
        $this->view = $container->get("view");
    }

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
        
        $demos = array();
        
        // Set up database and you can use it
//        $demos = $this->em->getRepository('Vendor\Bundle\Entity\Demo')->findAll();

        // Render index view
        return $this->view->render($response, 'index.html.twig', array_merge($args, array('demos' => $demos)));
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
