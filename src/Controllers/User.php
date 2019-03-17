<?php

namespace App\Controllers;

use App\Repositories;
use Exception;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Controller para tratar as requisições de Usuário
 *
 * Class User
 * @package App\Controllers
 */
class User extends Controller
{

    /**
     * User constructor.
     * @param Repositories\User $repository
     */
    public function __construct(Repositories\User $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @todo 1. Mapear todas as possíveis exceptions
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     *
     * @return ResponseInterface
     */
    public function create(ServerRequestInterface $request, ResponseInterface $response)
    {
        try {
            $parameters = $request->getParsedBody();

            $this->repository->createUser($parameters);

            return $response->withStatus(201);

        } catch (Exception $exception) {
            return $response->withJson($exception->getMessage(), 400);
        }
    }
}