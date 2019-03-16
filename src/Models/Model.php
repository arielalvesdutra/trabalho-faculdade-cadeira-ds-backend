<?php

namespace App\Models;

use PDO;
use PDOStatement;

/**
 * @todo documentar
 *
 * Class Model
 * @package App\Models
 */
abstract class Model
{
    protected $filters;

    protected $pdo;

    protected $tableName;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    abstract public function addFilters(array $filters);

    public function delete(int $id)
    {
        $query = $this->getPdo()->prepare("DELETE FROM ". $this->getTableName() . " WHERE id = :id");
        $query->bindParam(":id", $id);
        $query->execute();
    }

    abstract public function find();

    abstract public function findFirst();

    public function getFilters(): array
    {
        return $this->filters;
    }

    public function getPdo(): PDO
    {
        return $this->pdo;
    }

    public function getTableName()
    {
        return $this->tableName;
    }

    public function setTableName(string $tableName)
    {
        $this->tableName = $tableName;
    }

    abstract public function save($entity);
    abstract public function update($entity);

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

    abstract protected function bindValues(PDOStatement $pdoStatement) : PDOStatement;
}