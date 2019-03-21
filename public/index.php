<?php

require '../bootstrap.php';

use App\Controllers;
use App\Middlewares\Auth;
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
 * Define configuração de middleware e de debug
 */
$container->get('settings')
    ->replace([
        'debug' => true,
        'determineRouteBeforeAppMiddleware' => true,
        'displayErrorDetails' => true
]);

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
 * Autenticação
 */
$slim->post('/sigin', Auth::class . ':sigIn');

/**
 * Rotas que precisam de autenticação
 */
$slim->group('', function() use ($slim) {

    /**
     * Rota de teste
     */
    $slim->get('/te', function($request, $response){
        return $response->withJson("Teste");
    });

    /**
     * Users
     */
    $slim->post('/users', Controllers\User::class . ':create');
})->add(new Auth());


$slim->run();
