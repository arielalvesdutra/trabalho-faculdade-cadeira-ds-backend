<?php

namespace App\Controllers;

use App\Repositories;
use Exception;
use Firebase\JWT\JWT;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Controller para tratar as requisições de Ajuste de Horas
 *
 * Class HourAdjustment
 * @package App\Controllers
 */
class HourAdjustment extends Controller
{

    /**
     * User constructor.
     * @param Repositories\HourAdjustment $repository
     */
    public function __construct(Repositories\HourAdjustment $repository)
    {
        $this->repository = $repository;
    }

    public function create(ServerRequestInterface $request, ResponseInterface $response)
    {
        try {
            $parameters = $request->getParsedBody();

            $token = $request->getHeaderLine('Authorization');

            $payload = $this->decodeToken($token);

            $parameters['id_user'] = $payload['id'];

//            debugd($parameters);

            $this->repository->createHourAdjustment($parameters);

            return $response->withStatus(201);

        } catch (Exception $exception) {
            return $response->withJson($exception->getMessage(), 400);
        }
    }
}
