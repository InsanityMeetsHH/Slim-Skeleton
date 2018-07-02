<?php
namespace App\Controller;

/**
 * ErrorController is used for error pages
 */
class ErrorController extends BaseController {

    /**
     * Not found Action
     * 
     * @param \Slim\Http\Request $request
     * @param \Slim\Http\Response $response
     * @return \Slim\Http\Response
     */
    public function notFound($request, $response) {
        // Render view
        $this->logger->warning("Route '" . $_SESSION['notFoundRoute'] . "' not found - ErrorController:notFound");
        return $this->view->render($response, 'error/not-found.html.twig', [])->withStatus(404);
    }

    /**
     * Not allowed Action
     * 
     * @param \Slim\Http\Request $request
     * @param \Slim\Http\Response $response
     * @param array $args
     * @return \Slim\Http\Response
     */
    public function notAllowed($request, $response, $args) {
        // Render view
        $this->logger->warning("Route '" . $_SESSION['notAllowedRoute'] . "' not allowed '" . $_SESSION['notAllowedMethod'] . "' - ErrorController:notAllowed");
        return $this->view->render($response, 'error/not-allowed.html.twig', [
            'methods' => $_SESSION['allowedMethods'],
        ])->withStatus(405)->withHeader('Allow', str_replace('-', ', ', $_SESSION['allowedMethods']));
    }

    /**
     * Unauthorized Action
     * 
     * @param \Slim\Http\Request $request
     * @param \Slim\Http\Response $response
     * @return \Slim\Http\Response
     */
    public function unauthorized($request, $response) {
        // Render view
        $this->logger->warning("Route '" . $request->getUri()->getPath() . "' unauthorized - ErrorController:unauthorized");
        return $this->view->render($response, 'error/unauthorized.html.twig', [])->withStatus(401);
    }

    /**
     * Bad request Action
     * 
     * @param \Slim\Http\Request $request
     * @param \Slim\Http\Response $response
     * @return \Slim\Http\Response
     */
    public function badRequest($request, $response) {
        // Render view
        $this->logger->warning("Bad request - ErrorController:badRequest");
        return $this->view->render($response, 'error/bad-request.html.twig', [])->withStatus(400);
    }
}
