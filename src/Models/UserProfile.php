<?php

namespace App\Models;

use App\Entities;
use App\Exceptions\NotFoundException;
use PDO;
use PDOStatement;

class UserProfile extends Model
{
    protected $tableName = "user_profiles";

    /**
     * @param array $filters
     *
     * @return $this|mixed
     */
    public function addFilters(array $filters)
    {
        foreach ($filters as $key => $filter) {
            $this->filters[$key] = $filter;
        }

        return $this;
    }

    /**
     * @return array
     *
     * @throws NotFoundException
     */
    public function find()
    {
        $stm = $this->getPdo()->prepare($this->buildFindQuery());
        $stm = $this->bindValues($stm);

        $stm->execute();
        $stm->setFetchMode(PDO::FETCH_CLASS, 'App\Entities\UserProfile');

        $entities = $stm->fetchAll();

        if (empty($entities)) {
            throw new NotFoundException("Nenhum registro encontrado");
        }

        return $entities;
    }

    /**
     * @return Entities\UserProfile
     *
     * @throws NotFoundException
     */
    public function findFirst()
    {
        $stm = $this->pdo->prepare($this->buildFindQuery());
        $stm = $this->bindValues($stm);

        $stm->execute();
        $stm->setFetchMode(PDO::FETCH_CLASS, 'App\Entities\UserProfile');

        $entity = $stm->fetch();

        if (empty($entity)) {
            throw new NotFoundException("Nenhum registro encontrado");
        }

        return $entity;
    }


    /**
     * @param $entity Entities\UserProfile
     *
     * @return mixed|string
     */
    public function save($entity)
    {
        $stm = $this->getPdo()->prepare(
            "INSERT INTO " . $this->getTableName() . " " .
            "(name, code) VALUES (:name, :code)"
        );

        $stm->bindValue(':name',$entity->getName());
        $stm->bindValue(':code',$entity->getCode());

        $stm->execute();

        $id = $this->getPdo()->lastInsertId();

        return $id;
    }

    /**
     * @param $entity Entities\UserProfile
     *
     * @return mixed|void
     */
    public function update($entity)
    {
        $stm = $this->getPdo()->prepare(
            "UPDATE " . $this->getTableName() . " " .
            "SET name = :name, code = :code " .
            "WHERE id = :id"
        );

        $stm->bindValue(':id',$entity->getId());
        $stm->bindValue(':name',$entity->getName());
        $stm->bindValue(':code',$entity->getCode());

        $stm->execute();
    }

    /**
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

        if (isset($filters['code'])) {
            $pdoStatement->bindValue(':code', $filters['code']);
        }

        return $pdoStatement;
    }
}