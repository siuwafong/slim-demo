<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

$app = AppFactory::create();

$app->get('/friends/all', function (Request $request, Response $response) {
    $sql = "SELECT * FROM friends";

    print_r($_ENV["DB_HOST"]);

    try {
        $db = new DB();
        $conn = $db->connect();
        // stmt = statement
        $stmt = $conn->query($sql);
        $friends = $stmt->fetchAll(PDO::FETCH_OBJ);

        $db = null; // set it to null so that you don't get an error when you make another request
        $response->getBody()->write(json_encode($friends));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(200);
    } catch (PDOException $e) {
        $error = array(
            "message" => $e->getMessage() // gets the message from the error
        );

        $response->getBody()->write(json_encode($error));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(500);
    }
})->setName('allFriends');


$app->get('/friends/log', function (Request $request, Response $response, array $args) use ($app) {

    $routeParser = $app->getRouteCollector()->getRouteParser();

    echo $routeParser->urlFor('allFriends');
});

$app->get('/friends/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['id'];

    $sql = "SELECT * FROM friends WHERE id = $id";

    try {
        $db = new DB();
        $conn = $db->connect();
        // stmt = statement
        $stmt = $conn->query($sql);
        $friends = $stmt->fetchAll(PDO::FETCH_OBJ);

        $db = null; // set it to null so that you don't get an error when you make another request
        $response->getBody()->write(json_encode($friends));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(200);
    } catch (PDOException $e) {
        $error = array(
            "message" => $e->getMessage() // gets the message from the error
        );

        $response->getBody()->write(json_encode($error));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(500);
    }
})->setName('individualFriend');

$app->post('/friends/add', function (Request $request, Response $response, array $args) {

    $email = $request->getParam('email');
    $display_name = $request->getParam('display_name');
    $phone = $request->getParam('phone');

    $sql = "INSERT INTO friends (email, display_name, phone) VALUES (:email, :display_name, :phone)";

    try {
        $db = new DB();
        $conn = $db->connect();
        // stmt = statement
        $stmt = $conn->prepare($sql);

        // bind variables to query
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':display_name', $display_name);
        $stmt->bindParam(':phone', $phone);

        $result = $stmt->execute();

        $db = null; // set it to null so that you don't get an error when you make another request
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(200);
    } catch (PDOException $e) {
        $error = array(
            "message" => $e->getMessage() // gets the message from the error
        );

        $response->getBody()->write(json_encode($error));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(500);
    }
});

$app->delete('/friends/delete/{id}', function (Request $request, Response $response, array $args) {

    $id = $args['id'];

    $sql = "DELETE FROM friends WHERE id = $id";

    try {
        $db = new DB();
        $conn = $db->connect();
        // stmt = statement
        $stmt = $conn->prepare($sql);

        $result = $stmt->execute();

        $db = null; // set it to null so that you don't get an error when you make another request
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(200);
    } catch (PDOException $e) {
        $error = array(
            "message" => $e->getMessage() // gets the message from the error
        );

        $response->getBody()->write(json_encode($error));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(500);
    }
});
