<?php

require '../bootstrap.php';

use App\Controllers;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\App;
use Slim\Container;

/**
 * Containers
 */
$container = new Container();
/**
 * Injeta as dependências da controller User
 *
 * @return Controllers\User
 */
$container[Controllers\User::class] = function ()
{
  return new \App\Controllers\User(

      new \App\Repositories\User(
        new  \App\Models\User(
            \App\Databases\Factories\Connections\DefaultDatabaseConnection::getConnection()
        )
      )
  );
};

/**
 * Instancia o slim
 */
$slim = new App($container);

/**
 * Rotas
 */

$slim->get('/', function (RequestInterface $request, ResponseInterface $response){
    return $response->withJson("Primeira rota.");
});

/**
 * Users
 */
$slim->post('/users', Controllers\User::class . ':create');

$slim->run();
