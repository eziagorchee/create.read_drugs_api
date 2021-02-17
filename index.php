<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require __DIR__.'/./vendor/autoload.php';

require __DIR__.'/./src/config/db.php';



$app = new \Slim\App;

$app->get('/', function (Request $request, Response $response, array $args) {

    $response->getBody()->write("Hello, Welcome to the home page.");

    return $response;
});

require __DIR__.'/./src/routes/drugs.php';


$app->run();

