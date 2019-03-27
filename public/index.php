<?php

require '../bootstrap.php';

use App\Controllers;
use App\Middlewares\AccessControlAllow;
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
 * Injeta as dependências da controller UserProfile
 *
 * @return Controllers\UserProfile
 */
$container[Controllers\UserProfile::class] = function ()
{
    return new \App\Controllers\UserProfile(

        new \App\Repositories\UserProfile(
            new  \App\Models\UserProfile(
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
 * Configuração referente ao CORS
 * @see https://www.slimframework.com/docs/v3/cookbook/enable-cors.html
 */
$slim->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

/**
 * Configuração referente ao CORS
 * @see https://www.slimframework.com/docs/v3/cookbook/enable-cors.html
 */
$slim->add(new AccessControlAllow());

/**
 * Rotas
 */

$slim->get('/', function (RequestInterface $request, ResponseInterface $response){
    return $response->withJson("Primeira rota.");
});

/**
 * Autenticação
 */
$slim->post('/signin', Auth::class . ':signIn');

/**
 * Users
 */
$slim->get('/users[/]', Controllers\User::class . ':retrieveAll');
$slim->get('/users/{id}', Controllers\User::class . ':retrieve');
$slim->post('/users', Controllers\User::class . ':create');

/**
 * User Profile
 */
$slim->post('/user-profile', Controllers\UserProfile::class . ':create');


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
     * @todo adicionar rotas de usuários  que precisam de autenticação
     */
})->add(new Auth());


$slim->run();
