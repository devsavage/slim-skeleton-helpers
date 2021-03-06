<?php

namespace SlimSkeleton\Http\Controllers;

use Psr\Container\ContainerInterface;
use Slim\Interfaces\RouteParserInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface as Response;

class Controller
{
    protected $_container, $_view, $_router;
    
    public function __construct(ContainerInterface $container)
    {
        $this->_container = $container;
        $this->_view = $container->get("view");
        $this->_router = $container->get(RouteParserInterface::class);
    }

    public function __get($property) 
    {
        if ($this->_container->has($property)) {
            return $this->_container->get($property);
        }
    }
    
    protected function render(Response $response, string $templatePath)
    {
        return $this->_view->render($response, $templatePath . ".twig");
    }

    protected function redirect(Response $response, string $to, array $urlData = [], array $urlParams = [], string $urlQuery = null): Response
    {
        $response = $this->_container->get(ResponseFactoryInterface::class)->createResponse(302);
        
        if($urlQuery) {
            return $response->withHeader("Location", $this->buildUrl($this->_router->urlFor($to, $urlData, $urlParams) . $urlQuery));
        }

        return $response->withHeader("Location", $this->buildUrl($this->_router->urlFor($to, $urlData, $urlParams)));
    }

    private function buildUrl($uri)
    {
        return env("APP_URL") . $uri;
    }
}