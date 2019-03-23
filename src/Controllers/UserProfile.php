<?php

namespace App\Controllers;

use App\Repositories;
use Exception;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Controller para tratar as requisições de Usuário
 *
 * Class UserProfile
 * @package App\Controllers
 */
class UserProfile extends Controller
{

    /**
     * User constructor.
     * @param Repositories\UserProfile $repository
     */
    public function __construct(Repositories\UserProfile $repository)
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

            $this->repository->createUserProfile($parameters);

            return $response->withStatus(201);

        } catch (Exception $exception) {
            return $response->withJson($exception->getMessage(), 400);
        }
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * 
     * @return mixed
     */
    public function retrieve(ServerRequestInterface $request, ResponseInterface $response)
    {
        try {

            $id = $request->getAttribute('id');

            $user = $this->repository->retrieveUserProfile($id);

            return $response->withJson($user, 200);

        } catch (Exception $exception) {
            return $response->withJson($exception->getMessage(), 400);
        }

    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     *
     * @return mixed
     */
    public function retrieveAll(ServerRequestInterface $request, ResponseInterface $response)
    {
        try {
            $users =  $this->repository->retrieveAllUserProfiles();

            return $response->withJson($users, 200);
        } catch (Exception $exception) {
            return $response->withJson($exception->getMessage(), 400);
        }
    }
}