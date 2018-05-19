<?php
namespace App\Repository;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Permissions\Acl\Exception\InvalidArgumentException;

class AclRepository extends \Geggleto\Acl\AclRepository
{

    /**
     * Overloads __invoke method
     * 
     * @param \Psr\Http\Message\ServerRequestInterface $requestInterface
     * @param \Psr\Http\Message\ResponseInterface      $responseInterface
     * @param callable                                 $next
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke(ServerRequestInterface $requestInterface, ResponseInterface $responseInterface, callable $next) {
        $allowed = false;

        $route = '/' . ltrim($requestInterface->getUri()->getPath(), '/');

        //check to see if the its in the white list
        foreach ($this->whiteList as $whiteUri) {
            if (strpos($route, $whiteUri) !== false) {
                $allowed = true;
            }
        }

        if (!$allowed) {
            try {
                $allowed = $this->isAllowedWithRoles($this->role, $route);
            } catch (InvalidArgumentException $iae) {
                $fn = $this->handler;
                $allowed = $fn($requestInterface, $this);
            }
        }

        if ($allowed) {
            return $next($requestInterface, $responseInterface);
        } else {
            $error = new \App\Controller\ErrorController(\App\Container\AppContainer::getInstance()->getContainer());
            return $error->unauthorized($requestInterface, $responseInterface);
//            return $responseInterface->withStatus(401);
        }
    }
}