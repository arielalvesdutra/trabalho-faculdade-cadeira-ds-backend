<?php

namespace App\Controllers;

use App\Exceptions\ForbiddenException;
use App\Repositories;
use Exception;
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

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     *
     * @return ResponseInterface
     */
    public function create(ServerRequestInterface $request, ResponseInterface $response)
    {
        try {
            $parameters = $request->getParsedBody();

            $token = $request->getHeaderLine('Authorization');

            $payload = $this->decodeToken($token);

            $parameters['userId'] = $payload['id'];

            $this->repository->createHourAdjustment($parameters);

            return $response->withStatus(201);

        } catch (Exception $exception) {
            return $response->withJson($exception->getMessage(), 400);
        }
    }

    public function delete(ServerRequestInterface $request, ResponseInterface $response)
    {
        try {

            $parameters['id_adjustment'] = $request->getAttribute('id');

            $token = $request->getHeaderLine('Authorization');

            $payload = $this->decodeToken($token);

            $parameters['id_user'] = $payload['id'];

            $this->repository->deleteHourAdjustment($parameters);

            return $response->withStatus(200);

        } catch (Exception $exception) {

            return $response->withJson($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     *
     * @return ResponseInterface
     */
    public function retrieveEmployeeAdjustments(ServerRequestInterface $request, ResponseInterface $response)
    {
        try {

            $userId = $request->getAttribute('id');

            $token = $request->getHeaderLine('Authorization');

            $payload = $this->decodeToken($token);

            $parameters['id_user'] = $payload['id'];

            if ($userId !== $parameters['id_user']) {
                throw new ForbiddenException('Usuário não autorizado.');
            }

            $hoursAdjustments = $this->repository->retrieveEmployeeAdjustments($parameters);

            return $response->withJson($hoursAdjustments, 200);

        } catch (Exception $exception) {
            return $response->withJson($exception->getMessage(), $exception->getCode());
        }
    }
}
