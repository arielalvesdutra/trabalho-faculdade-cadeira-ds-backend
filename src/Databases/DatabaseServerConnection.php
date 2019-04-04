<?php

namespace App\Databases;

use Exception;
use PDO;
use PDOException;

/**
 * Essa classe representa a conexão com o servidor de banco de dados,
 * com as operações de criar ou remover bases de dados.
 *
 * Class DatabaseServerConnection
 * @package App\Database
 */
class DatabaseServerConnection
{
    /**
     * @var string
     */
    protected $databaseName;

    /**
     * @var PDO
     */
    protected $pdo;

    /**
     * DatabaseServerConnection constructor.
     *
     * @param string $host
     * @param string $user
     * @param string $password
     * @param int $port
     * @param string|null $database
     *
     * @throws PDOException
     */
    public function __construct(string $host, string $user,
                                string $password, int $port = 3306, string $database = '')
    {

        $this->pdo = new PDO(
            $this->buildServerConnectionSDN($host, $port, $database),
            $user,
            $password
        );

        $this->databaseName = $database;
    }

    /**
     * @param string $databaseName
     *
     * @throws Exception
     */
    public function createDatabase(string $databaseName)
    {
        $result = $this->getPdo()->exec(
            "CREATE DATABASE " . $databaseName
        );

        if ($result === false) {
            throw new Exception("Erro ao criar a base de dados.");
        }
    }

    /**
     * @param string $databaseName
     *
     * @throws Exception
     */
    public function createDatabaseIfNotExists(string $databaseName)
    {
        $result = $this->getPdo()->exec(
            "CREATE DATABASE IF NOT EXISTS " . $databaseName
        );

        if ($result === false) {
            throw new Exception("Erro ao criar a base de dados.");
        }
    }

    /**
     * @param string $databaseName
     *
     * @throws Exception
     */
    public function dropDatabase(string $databaseName)
    {
        $result = $this->getPdo()->exec(
            "DROP DATABASE " . $databaseName
        );

        if ($result === false) {
            throw new Exception("Erro ao excluir a base de dados.");
        }
    }

    /**
     * Retorna o nome da base de dados, caso ela tenha sido setada
     * na criação do DatabaseServerConnection ou
     * retorna um string vazia.
     *
     * @return string
     */
    public function getDatabaseName() : string
    {
        return $this->databaseName;
    }

    /**
     * @return PDO
     */
    public function getPdo() : PDO
    {
        return $this->pdo;
    }

    /**
     * @param string $databaseName
     *
     * @return bool
     */
    public function hasDatabase(string $databaseName): bool
    {

        if ($this->getPdo()->exec("USE " . $databaseName) === false) {
            return false;
        }

        return true;
    }

    /**
     * @param string $host
     * @param int $port
     * @param string|null $database
     *
     * @return string
     */
    private function buildServerConnectionSDN(string $host,
                                              int $port = 3306, ?string $database) : string
    {
        if (!empty($database)) {

            return "mysql:" .
                "host=" . $host . ";" .
                "port=" . $port. ";" .
                "dbname=" . $database . ";" .
                "charset=utf8";
        }

        return "mysql:" .
            "host=" . $host . ";" .
            "port=" . $port. ";";
    }
}