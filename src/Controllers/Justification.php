<?php

namespace App\Controllers;

use App\Repositories;
use Exception;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Controller para tratar as requisições de Justificativas
 *
 * Class Justification
 * @package App\Controllers
 */
class Justification extends Controller
{

    /**
     * User constructor.
     * @param Repositories\Justification $repository
     */
    public function __construct(Repositories\Justification $repository)
    {
        $this->repository = $repository;
    }


    public function create(ServerRequestInterface $request, ResponseInterface $response)
    {
        try {

            $parameters = $request->getParsedBody();

            $this->repository->createJustification($parameters);

            return $response->withStatus(201);

        } catch (Exception $exception) {
            return $response->withJson($exception->getMessage(), 400);
        }
    }
}
