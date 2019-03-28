<?php

namespace App\Models;

use App\Entities;
use App\Exceptions\NotFoundException;
use LogicException;
use PDO;
use PDOStatement;

/**
 * Model de Ajuste de Horas
 *
 * Class Justification
 * @package App\Models
 */
class Justification extends Model
{
    /**
     * @var string $tableName
     */
    protected $tableName = "justifications";


    public function addFilters(array $filters)
    {
        throw new LogicException('Método não implementado');
    }

    public function find()
    {
        throw new LogicException('Método não implementado');
    }

    /**
     * @return Entities\Justification[]
     *
     * @throws NotFoundException
     */
    public function findAll()
    {
        $query = "SELECT * FROM " . $this->getTableName();

        $stm = $this->getPdo()->prepare($query);

        $stm->execute();
        $stm->setFetchMode(PDO::FETCH_CLASS, 'App\Entities\Justification');

        $entities = $stm->fetchAll();

        if (empty($entities)) {
            throw new NotFoundException("Nenhum registro encontrado");
        }

        return $entities;
    }

    /**
     * @param $id
     *
     * @return Entities\Justification
     *
     * @throws NotFoundException
     */
    public function findById($id)
    {
        $query = "SELECT * FROM " . $this->getTableName() . " ".
                 "WHERE id = :id";

        $stm = $this->getPdo()->prepare($query);
        $stm->bindParam(':id', $id);
        $stm->execute();
        $stm->setFetchMode(PDO::FETCH_CLASS, 'App\Entities\Justification');

        $entity = $stm->fetch();

        if (empty($entity)) {
            throw new NotFoundException("Nenhum registro encontrado");
        }

        return $entity;
    }

    public function findByTitle(string $title)
    {
        $query = "SELECT * FROM " . $this->getTableName() . " ".
            "WHERE title = :title";

        $stm = $this->getPdo()->prepare($query);
        $stm->bindParam(':title', $title);
        $stm->execute();
        $stm->setFetchMode(PDO::FETCH_CLASS, 'App\Entities\Justification');

        $entity = $stm->fetch();

        if (empty($entity)) {
            throw new NotFoundException("Nenhum registro encontrado");
        }

        return $entity;
    }

    public function findFirst()
    {
        throw new LogicException('Método não implementado');
    }


    /**
     * @param $entity Entities\Justification
     *
     * @return mixed
     */
    public function save($entity)
    {
        $query = "INSERT INTO " . $this->getTableName() ." " .
                 "(title) VALUES (:title)";

        $stm = $this->getPdo()->prepare($query);
        $stm->bindParam(':title', $entity->getTitle());

        $id = $stm->execute();

        return $id;
    }

    /**
     * @param $entity Entities\Justification
     */
    public function update($entity)
    {
        $query = "UPDATE " . $this->getTableName() . " " .
                 "SET title = :title " .
                 "WHERE id = :id";

        $stm = $this->getPdo()->prepare($query);
        $stm->bindParam(':id', $entity->getId());
        $stm->bindParam(':title', $entity->getTitle());

        $stm->execute();
    }

    protected function bindValues(PDOStatement $pdoStatement): PDOStatement
    {
        throw new LogicException('Método não implementado');
    }
}
