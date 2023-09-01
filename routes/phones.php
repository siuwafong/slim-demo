<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use Mailgun\Mailgun;
use App\Controller\HomeController;
use App\Controller\ExampleBeforeMiddleware;

$app = AppFactory::create();
require __DIR__ . '/../routes/friends.php';

// $app->add(new ExampleBeforeMiddleware());

$app->get('/controller-test', [HomeController::class, 'index'])
    ->add(new ExampleBeforeMiddleware());

$app->group('/phones', function (RouteCollectorProxy $group) {
    $group->get('/all', function (Request $request, Response $response) {

        $phones = ["test" => "example"];

        $response->getBody()->write(json_encode($phones));

        $mgClient = Mailgun::create('90aa7fe68fc03d042f8956d15b257aa0-451410ff-586c50aa');
        $domain = "sandbox09dc9fc33c78429c9dd65536c9a7096a.mailgun.org";

        $result = $mgClient->messages()->send($domain, array(
            'from'    => 'Excited User <wilson@sandbox09dc9fc33c78429c9dd65536c9a7096a.mailgun.org>',
            'to'    => 'Wilson Fong <wilsonfong1002@outlook.com>',
            'subject' => 'Hello',
            'text'    => 'Testing some Mailgun awesomeness!'
        ));

        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(200);
    });

    $group->redirect('/redirect', '/friends/all', 301);

    $group->post('/{id}', function (Request $request, Response $response, array $args) {
        echo ("args is: " . $args['id']);
    });

    $group->get('/controller/{id}', \App\Action\PhoneAction::class)->add(new ExampleBeforeMiddleware());;

    $group->get('/controller2/{id}',  \App\Controller\HomeController::class);
});
