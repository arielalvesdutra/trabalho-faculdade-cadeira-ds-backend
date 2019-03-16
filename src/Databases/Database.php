<?php

namespace App\Databases;

use PDO;
use Exception;

/**
 * Essa classe representa a conexão com uma base de dados,
 * com as operações de criar e remover tabelas na base.
 *
 * Class Database
 * @package App\Database
 */
class Database
{
    /**
     * Nome da base de dados desse objeto.
     *
     * @var string
     */
    protected $databaseName;

    /**
     * Objeto PDO para que a classe Database possa realizar operações
     * com o banco de dados.
     *
     * @var PDO
     */
    protected $pdo;

    public function __construct(DatabaseServerConnection $databaseServerConnection)
    {
        $this->pdo = $databaseServerConnection->getPdo();

        $this->databaseName = $databaseServerConnection->getDatabaseName();
    }

    /**
     * @param Table $table
     *
     * @throws Exception
     */
    public function createTable(Table $table)
    {
        $create = "CREATE TABLE " . $table->getTableName();

        $columns = "(" . $table->getColumnsDDL();
        $columns .= $table->getPrimaryKey()
            ? "," . $table->getPrimaryKey()
            : '';
        $columns .= ")";

        $engine = $table->getEngine()->getEngine()
            ?"engine=". $table->getEngine()->getEngine() . ";"
            : '';

        $ddl = $create . $columns . $engine;

        $this->getPdo()->exec($ddl);
    }

    /**
     * @param Table $table
     *
     * @throws Exception
     */
    public function createTableIfNotExists(Table $table)
    {
        $create = "CREATE TABLE IF NOT EXISTS " . $table->getTableName();

        $columns = "(" . $table->getColumnsDDL();
        $columns .= $table->getPrimaryKey()
            ? "," . $table->getPrimaryKey()
            : '';
        $columns .= ")";

        $engine = $table->getEngine()->getEngine()
            ?"engine=". $table->getEngine()->getEngine() . ";"
            : '';

        $ddl = $create . $columns . $engine;

        $this->getPdo()->exec($ddl);
    }

    /**
     * @param string $tableName
     */
    public function dropTable(string $tableName)
    {
        $this->getPdo()->exec("DROP TABLE " . $tableName);
    }

    /**
     * Retorna o nome da database desse objeto.
     *
     * @return string
     */
    public function getDatabaseName() : string
    {
        return $this->databaseName;
    }

    /**
     * Retorna o objeto PDO da Database.
     *
     * @return PDO
     */
    public function getPdo() : PDO
    {
        return $this->pdo;
    }

    /**
     * Realiza consulta na tabela para verificar se ela existe.
     * Caso a tabela não exista, o PDO->exe() retorna false.
     * Caso a tabela exista e não tenha registros, o PDO->exe() retorna 0;
     *
     * @param string $tableName
     *
     * @return bool
     */
    public function hasTable(string $tableName) : bool
    {
        if ($this->getPdo()->exec("SELECT * FROM " . $tableName . " LIMIT 1,1") === false) {
            return false;
        }

        return true;
    }
}
