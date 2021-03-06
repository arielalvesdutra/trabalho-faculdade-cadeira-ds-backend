<?php

namespace App\Middlewares;

use App\Databases\Factories\Connections\DefaultDatabaseConnection;
use App\Models;
use App\Repositories;
use Exception;
use Firebase\JWT\JWT;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Middleware de Autenticação
 *
 * Class Auth
 * @package App\Middlewares
 */
class Auth
{

    /**
     * Expressão Regular para verificar se possui o bearer
     * (case insensitive) no inicio da string
     */
    const BEARER_REGEX = "/(^bearer)/i";

    /**
     * Caso o token JWT seja inválido, é retornado o status 401
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param $next
     *
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $next)
    {

        try {

            $this->validateToken($request->getHeaderLine('Authorization'));

            return $next($request, $response);

        } catch (Exception $exception) {
            return $response->withStatus(401);
        }
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     *
     * @return mixed
     */
    public function signIn(ServerRequestInterface $request, ResponseInterface $response)
    {

        $parameters = $request->getParsedBody();

        try {

            $secret = $this->getSecret();

            $email = $this->getEmailRequestParameter($parameters);
            $password = $this->getPasswordRequestParameter($parameters);

            $userRepository = new Repositories\User(
                new Models\User(
                    DefaultDatabaseConnection::getConnection()
                )
            );

            $user = $userRepository->retrieveUserByEmailAndPassword([
                'email' => $email ,
                'password' => $password
            ]);

            $payload = [
                'id' => $user['id'],
                'name'  => $user['name'],
                'email'  => $user['email'],
                'userProfiles' => $user['userProfiles'],
                'iet' => time(),
                'exp' => $this->getTimestamp10MinutesForward()
            ];

            $token = JWT::encode($payload, $secret);

            return $response->withJson([
                'payload' => $payload,
                'token' => $token
            ]);

        } catch (Exception $exception) {
            return $response->withJson('Email ou senha inválido!', 400);
        }
    }

    /**
     * @param array $requestParameters
     *
     * @return mixed
     *
     * @throws Exception
     */
    private function getEmailRequestParameter(array $requestParameters)
    {
        $email = $requestParameters['email'];

        if (!empty($email)) {
            return $email;
        }

        throw new Exception('E-mail está vazio');
    }

    /**
     * @param array $requestParameters
     *
     * @return mixed
     *
     * @throws Exception
     */
    private function getPasswordRequestParameter(array $requestParameters)
    {
        $email = $requestParameters['password'];

        if (!empty($email)) {
            return $email;
        }

        throw new Exception('Password está vazio');
    }

    /**
     * Retorna o secret do JWT configurado no arquivo .env
     *
     * @return mixed
     *
     * @throws Exception
     */
    private function getSecret()
    {
        if (!empty($_ENV['AUTH_SECRET'])){
            return $_ENV['AUTH_SECRET'];
        }

        throw new Exception('Secret não está configurado!');
    }

    private function getTimestamp30SecondsForward()
    {
        return time() + (30);
    }

    /**
     * @return int
     */
    private function getTimestamp10MinutesForward()
    {
        return time() + (60 * 10);
    }

    private function getTimestamp60MinutesForward()
    {
        return time() + (60 * 60);
    }

    /**
     * @param string $token
     *
     * @return string
     */
    private function removeBearerFromToken(string $token)
    {
        return str_replace(["bearer ", "Bearer "] , "" , $token);
    }

    /**
     * Verifica com a expressão regular se a string possui
     * a string bearer no seu inicio
     *
     * @param string $token
     *
     * @return bool
     */
    private function tokenHasBearer(string $token)
    {
        if (preg_match(self::BEARER_REGEX, $token)) {
            return true;
        }

        return false;
    }

    /**
     * @param string $token
     *
     * @throws Exception
     */
    private function validateToken(string $token)
    {
        if (empty($token)) {
            throw new InvalidArgumentException('Token está vazio!');
        }

        if (!$this->tokenHasBearer($token)) {
            throw new InvalidArgumentException('O cabeçalho não utiliza o Bearer Schema!');
        }

        $secret = $this->getSecret();
        $algorithms = [ 'HS256' ];
        $tokenWithoutBearer = $this->removeBearerFromToken($token);

        JWT::decode($tokenWithoutBearer, $secret, $algorithms);
    }
}

