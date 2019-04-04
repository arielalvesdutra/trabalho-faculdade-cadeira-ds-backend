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

    public function approvalRequest(ServerRequestInterface $request, ResponseInterface $response)
    {
        try {
            $token = $request->getHeaderLine('Authorization');

            $payload = $this->decodeToken($token);

            $parameters['id_user'] = $payload['id'];

            $this->repository->employeeApprovalRequest($parameters);

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
            return $response->withJson($exception->getMessage(), $exception->getCode());
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

    public function retrieveEmployeeAdjustmentsStatus(ServerRequestInterface $request, ResponseInterface $response)
    {
        try {

            $userId = $request->getAttribute('id');
            $token = $request->getHeaderLine('Authorization');
            $payload = $this->decodeToken($token);

            $parameters['id_user'] = $payload['id'];

            if ($userId !== $parameters['id_user']) {
                throw new ForbiddenException('Usuário não autorizado.');
            }

            $adjustmentsStatus = $this->repository->retrieveEmployeeAdjustmentsStatus($parameters);

            return $response->withJson($adjustmentsStatus, 200);

        } catch (Exception $exception) {
            return $response->withJson($exception->getMessage(), $exception->getCode());
        }
    }

    public function searchEmployeeAdjustments(ServerRequestInterface $request, ResponseInterface $response)
    {
        try {
            $token = $request->getHeaderLine('Authorization');
            $payload = $this->decodeToken($token);
            $parameters = $request->getQueryParams();
            $parameters['id_user'] = $request->getAttribute('id');

            if ($payload['id'] !== $parameters['id_user']) {
                throw new ForbiddenException('Usuário não autorizado.');
            }

            $adjustments = $this->repository->searchEmployeeAdjustments($parameters);

            return $response->withJson($adjustments,200);

        } catch (Exception $exception) {
            return $response->withJson($exception->getMessage(), $exception->getCode());
        }
    }

    public function update(ServerRequestInterface $request, ResponseInterface $response)
    {
        try {
            $token = $request->getHeaderLine('Authorization');
            $payload = $this->decodeToken($token);

            $parameters = $request->getParsedBody();
            $parameters['id_adjustment'] = $request->getAttribute('id');
            $parameters['id_user'] =  $payload['id'];

            $this->repository->updateHourAdjustment($parameters);

            return $response->withStatus(200);

        } catch (Exception $exception) {
            return $response->withJson($exception->getMessage(), $exception->getCode());
        }
    }
}
