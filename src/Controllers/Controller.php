<?php

namespace App\Controllers;

use App\Formatters\Formatter;
use Firebase\JWT\JWT;

/**
 * Class Controller
 * @package App\Controllers
 */
abstract class Controller
{
    protected $repository;

    /**
     * @param string $token
     *
     * @return array
     */
    protected function decodeToken(string $token)
    {

        $algorithms = [ 'HS256' ];
        $secret = $this->getSecret();
        $tokenWithoutBearer = $this->removeBearerFromToken($token);

        $payload = Formatter::fromObjectToArray(
            JWT::decode($tokenWithoutBearer, $secret, $algorithms)
        );

        return $payload;
    }

    /**
     * Retorna o secret do JWT configurado no arquivo .env
     *
     * @return mixed
     */
    private function getSecret()
    {
        if (!empty($_ENV['AUTH_SECRET'])) {
            return $_ENV['AUTH_SECRET'];
        }

        throw new Exception('Secret não está configurado!');
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

}