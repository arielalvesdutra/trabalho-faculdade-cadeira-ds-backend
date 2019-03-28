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
 * Class User
 * @package App\Models
 */
class HourAdjustment extends Model
{
    /**
     * @var string $tableName
     */
    protected $tableName = "hours_adjusments";


    public function addFilters(array $filters)
    {
        throw new LogicException('Método não implementado');
    }

    public function find()
    {
        throw new LogicException('Método não implementado');
    }

    /**
     * @return Entities\HourAdjustment[]
     *
     * @throws NotFoundException
     */
    public function findAll()
    {
        $query = "SELECT * FROM " . $this->getTableName();

        $stm = $this->getPdo()->prepare($query);

        $stm->execute();
        $stm->setFetchMode(PDO::FETCH_CLASS, 'App\Entities\HourAdjustment');

        $entities = $stm->fetchAll();

        if (empty($entities)) {
            throw new NotFoundException("Nenhum registro encontrado");
        }

        return $entities;
    }

    /**
     * @param $id
     *
     * @return Entities\HourAdjustment
     *
     * @throws NotFoundException
     */
    public function findById($id)
    {
        $query = "SELECT * FROM " . $this->getTableName() . " ".
                 "WHERE id = :id";

        $stm = $this->getPdo()->prepare($query);
        $stm->bindParam(':id', $id);

        $stm->setFetchMode(PDO::FETCH_CLASS, 'App\Entities\HourAdjustment');

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
     * @param $entity Entities\HourAdjustment
     *
     * @return mixed
     */
    public function save($entity)
    {
        $query = "INSERT INTO " . $this->getTableName() ." " .
                 "(date, duration, entryHour, exitHour, id_justification, id_user) VALUES ".
                 "(:date, :duration, :entryHour, :exitHour, :id_justification, :id_user)";

        $stm = $this->getPdo()->prepare($query);
        $stm->bindParam(':date', $entity->getDate()->format('Y-m-d'));
        $stm->bindParam(':entryHour', $entity->getEntryHour()->format('H:i:s'));
        $stm->bindParam(':exitHour', $entity->getExitHour()->format('H:i:s'));
        $stm->bindParam(':duration', $entity->getDuration()->format('%h:%I:%S'));
        $stm->bindParam(':id_justification', $entity->getJustification()->getId());
        $stm->bindParam(':id_user', $entity->getUserId());

        $id = $stm->execute();

        return $id;
    }

    /**
     * @param $entity Entities\HourAdjustment
     */
    public function update($entity)
    {
        $query = "UPDATE " . $this->getTableName() . " " .
                 "SET date = :date, entryHour = :entryHour, exitHour = :exitHour," .
                    "duration = :duration, id_justification = :id_justification, id_user = :id_user " .
                 "WHERE id = :id";

        $stm = $this->getPdo()->prepare($query);
        $stm->bindParam(':id', $entity->getId());
        $stm->bindParam(':date', $entity->getDate()->format('Y-m-d'));
        $stm->bindParam(':entryHour', $entity->getEntryHour()->format('H:i:s'));
        $stm->bindParam(':exitHour', $entity->getExitHour()->format('H:i:s'));
        $stm->bindParam(':duration', $entity->getDuration()->format('%h:%I:%S'));
        $stm->bindParam(':id_justification', $entity->getJustification()->getId());
        $stm->bindParam(':id_user', $entity->getUserId());

        $stm->execute();
    }

    protected function bindValues(PDOStatement $pdoStatement): PDOStatement
    {
        throw new LogicException('Método não implementado');
    }
}
