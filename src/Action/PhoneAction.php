<?php

namespace App\Action;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class PhoneAction
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        print_r($args);
        $response->getBody()->write('Hello, Phone!');

        return $response;
    }
}
