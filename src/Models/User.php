<?php

namespace App\Models;

use App\Entities;
use App\Exceptions\NotFoundException;
use PDO;
use PDOStatement;

/**
 * Model de Usuários
 *
 * Class User
 * @package App\Models
 */
class User extends Model
{
    /**
     * @var string $tableName
     */
    protected $tableName = "users";

    /**
     * @param array $filters
     *
     * @return $this
     */
    public function addFilters(array $filters)
    {
        $this->filters = $filters;

        return $this;
    }

    /**
     * @return array
     *
     * @throws NotFoundException
     */
    public function find(): array
    {
        $stm = $this->getPdo()->prepare($this->buildFindQuery());
        $stm = $this->bindValues($stm);

        $stm->execute();
        $stm->setFetchMode(PDO::FETCH_CLASS, 'App\Entities\User');

        $entities = $stm->fetchAll();

        if (empty($entities)) {
            throw new NotFoundException("Nenhum registro encontrado");
        }

        return $entities;
    }

    /**
     * @return Entities\User
     *
     * @throws NotFoundException
     */
    public function findFirst(): Entities\User
    {
        $stm = $this->pdo->prepare($this->buildFindQuery());
        $stm = $this->bindValues($stm);

        $stm->execute();
        $stm->setFetchMode(PDO::FETCH_CLASS, 'App\Entities\User');

        $entity = $stm->fetch();

        if (empty($entity)) {
            throw new NotFoundException("Nenhum registro encontrado");
        }

        return $entity;
    }

    /**
     * @param $entity Entities\User
     *
     * @return bool
     */
    public function save($entity)
    {
        $stm = $this->getPdo()->prepare(
            "INSERT INTO " . $this->getTableName() . " " .
            "(name, email, password) VALUES (:name, :email, :password)"
        );

        $stm->bindValue(':name',$entity->getName());
        $stm->bindValue(':email',$entity->getEmail());
        $stm->bindValue(':password',$entity->getPassword());

        $stm->execute();

        $id = $this->getPdo()->lastInsertId();

        return $id;
    }

    /**
     * @param $entity Entities\User
     */
    public function update($entity)
    {
        $stm = $this->getPdo()->prepare(
            "UPDATE " . $this->getTableName() . " " .
            "SET name = :name, email = :email, password = :password " .
            "WHERE id = :id"
        );

        $stm->bindValue(':id',$entity->getId());
        $stm->bindValue(':name',$entity->getName());
        $stm->bindValue(':email',$entity->getEmail());
        $stm->bindValue(':password',$entity->getPassword());

        $stm->execute();
    }

    /**
     * Método para adicionar valores dos filtros à query de consulta
     *
     * @param PDOStatement $pdoStatement
     *
     * @return PDOStatement
     */
    protected function bindValues(PDOStatement $pdoStatement): PDOStatement
    {
        $filters = $this->getFilters();

        if (isset($filters['id'])) {
            $pdoStatement->bindValue(':id', $filters['id']);
        }

        if (isset($filters['name'])) {
            $pdoStatement->bindValue(':name', $filters['name']);
        }

        if (isset($filters['email'])) {
            $pdoStatement->bindValue(':email', $filters['email']);
        }

        if (isset($filters['password'])) {
            $pdoStatement->bindValue(':email', $filters['email']);
        }

        return $pdoStatement;
    }
}