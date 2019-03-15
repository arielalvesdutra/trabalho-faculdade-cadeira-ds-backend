<?php

require '../bootstrap.php';

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\App;

$slim = new App();


$slim->get('/', function (RequestInterface $request, ResponseInterface $response){
    return $response->withJson("Primeira rota.");
});


$slim->run();
