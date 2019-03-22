<?php

namespace App\Models;

use PDO;
use PDOStatement;

/**
 * Model para persistir, alterar, consultar e remover registros
 * em uma tabela no banco de dados.
 *
 * Class Model
 * @package App\Models
 */
abstract class Model
{
    /**
     * Atributo para realizar as consultas com o método find() ou findFirst()
     *
     * @var array $filters
     */
    protected $filters = [];

    /**
     * Atributo para realizar as operações com o banco de dados
     *
     * @var PDO $pdo
     */
    protected $pdo;

    /**
     * Nome da tabela que a Model opera no banco de dados
     *
     * @var string $tableName
     */
    protected $tableName;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Método para adicionar os filtros pare realiza consulta dos
     * registros no banco de dados
     *
     * @param array $filters
     *
     * @return mixed
     */
    abstract public function addFilters(array $filters);

    /**
     * @param int $id
     */
    public function delete(int $id)
    {
        $query = $this->getPdo()->prepare("DELETE FROM ". $this->getTableName() . " WHERE id = :id");
        $query->bindParam(":id", $id);
        $query->execute();
    }

    /**
     * @return mixed
     */
    abstract public function find();

    /**
     * @return mixed
     */
    abstract public function findFirst();

    /**
     * @return array
     */
    public function getFilters(): array
    {
        return $this->filters;
    }

    /**
     * @return PDO
     */
    public function getPdo(): PDO
    {
        return $this->pdo;
    }

    /**
     * @return string
     */
    public function getTableName()
    {
        return $this->tableName;
    }

    /**
     * @todo modificar método para setTestsEnvironment()
     *
     * @param string $tableName
     */
    public function setTableName(string $tableName)
    {
        $this->tableName = $tableName;
    }

    /**
     * @param $entity
     *
     * @return mixed
     */
    abstract public function save($entity);

    /**
     * @param $entity
     *
     * @return mixed
     */
    abstract public function update($entity);

    /**
     * Método que constroi a query para ser utilizada no PDO
     * para consultar os registros no banco
     *
     * @return string
     */
    protected function buildFindQuery()
    {
        $query = 'SELECT * FROM ' . $this->getTableName();

        if ($this->getFilters()) {

            $query .= ' WHERE ';

            $firstFilter = true;

            foreach ($this->getFilters() as $key => $filter) {
                if ($firstFilter) {
                    $query .= ' ' . $key . $filter;
                    $firstFilter = false;
                }
                else {
                    $query .= ' AND '. $key  . $filter;
                }
            }
        }

        return $query;
    }

    /**
     * Realiza a ligação dos parametros a uma operação com o PDO
     * a ser realizada
     *
     * @param PDOStatement $pdoStatement
     *
     * @return PDOStatement
     */
    abstract protected function bindValues(PDOStatement $pdoStatement) : PDOStatement;
}