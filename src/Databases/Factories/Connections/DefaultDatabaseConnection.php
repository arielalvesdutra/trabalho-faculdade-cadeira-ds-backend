<?php

namespace App\Databases\Factories\Connections;

use App\Databases;
use PDO;

/**
 * Essa factory é reponsável por retornar a conexão do banco
 * de dados padrão da aplicação.
 *
 * Class DefaultDatabaseConnection
 * @package App\Database\Factories\Connections
 */
class DefaultDatabaseConnection implements DatabaseConnectionFactoryInterface
{
    public function __construct()
    {
        if (empty($_ENV['MYSQL_HOST'])) {
            throw new Exception("Favor preencher o campo MYSQL_HOST no arquivo '.env'.");
        }

        if (empty($_ENV['MYSQL_PORT'])) {
            throw new Exception("Favor preencher o campo MYSQL_PORT no arquivo '.env'.");
        }

        if (empty($_ENV['MYSQL_USER'])) {
            throw new Exception("Favor preencher o campo MYSQL_USER no arquivo '.env'.");
        }

        if (empty($_ENV['MYSQL_PASSWORD'])) {
            throw new Exception("Favor preencher o campo MYSQL_PASSWORD no arquivo '.env'.");
        }

        if (empty($_ENV['MYSQL_DATABASE'])) {
            throw new Exception("Favor preencher o campo MYSQL_DATABASE no arquivo '.env'.");
        }
    }

    /**
     * @return PDO
     */
    public static function getConnection() : PDO
    {
        $databaseServerConnection =  new Databases\DatabaseServerConnection(
            $_ENV['MYSQL_HOST'],
            $_ENV['MYSQL_USER'],
            $_ENV['MYSQL_PASSWORD'],
            $_ENV['MYSQL_PORT'],
            $_ENV['MYSQL_DATABASE'],
        );

        return $databaseServerConnection->getPdo();
    }
}