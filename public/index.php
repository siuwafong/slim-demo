<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response as MiddlewareResponse;


require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/db.php';

$app = AppFactory::create();
// (require __DIR__ . '/../config/bootstrap.php')->run();

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

$app->get('/{name}', function (Request $request, Response $response, array $args) {
    $response->getBody()->write("Hello, " . "world");
    return $response;
});

// Friends routes
require __DIR__ . '/../routes/friends.php';

// Phones routes
require __DIR__ . '/../routes/phones.php';

// $app->add($beforeMiddleware);

$app->run();
