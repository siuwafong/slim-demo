<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Container\ContainerInterface;
use Slim\Factory\AppFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
// $app = AppFactory::create();


class HomeController
{
    private $container;

    // constructor receives container instance
    // public function __construct(ContainerInterface $container)
    // {
    //     $this->container = $container;
    // }

    public function index(Request $request, Response $response, array $args): Response
    {
        $response->getBody()->write("this is the home controller invoke method");

        return $response;
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $response->getBody()->write("this is the home controller invoke method");

        return $response;
    }

    public function home(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        // your code here
        // use $this->view to render the HTML
        // ...
        $response->getBody()->write("this is the home controller");

        return $response;
    }
}
