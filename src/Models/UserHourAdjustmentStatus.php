<?php

namespace App\Models;

use App\Entities;
use App\Exceptions\NotFoundException;
use App\Factories\Entities\UserHourAdjustmentStatusFactory;
use App\Factories\States\HourAdjustmentStateFactory;
use App\States;
use LogicException;
use PDO;
use PDOStatement;

/**
 * Model de Status de Ajuste de Horas por Usuário
 *
 * Class UserHourAdjustmentStatus
 * @package App\Models
 */
class UserHourAdjustmentStatus extends Model
{
    /**
     * @var string $tableName
     */
    protected $tableName = "users_hours_adjustments_status";

    public function addFilters(array $filters)
    {
        throw new LogicException('Método não implementado');
    }

    public function find()
    {
        throw new LogicException('Método não implementado');
    }

    /**
     * @param $userId
     *
     * @return Entities\UserHourAdjustmentStatus
     *
     * @throws NotFoundException
     */
    public function findByUserId($userId)
    {
        $query = "SELECT uhas.id_user, uhas.id_status, has.code " .
                 "FROM " . $this->getTableName() . " as uhas " .
                 "INNER JOIN hours_adjustments_status as has " .
                 "ON has.id = uhas.id_status " .
                 "WHERE id_user = :id_user";
        $stm = $this->getPdo()->prepare($query);
        $stm->bindParam(':id_user', $userId);
        $stm->execute();

        $record = $stm->fetch(PDO::FETCH_ASSOC);


        if (empty($record)) {
            throw new NotFoundException(
                'Registro de Usuário Status Ajuste de Horas não encontrado!');
        }

        $entity = UserHourAdjustmentStatusFactory::create(
            new Entities\User($record['id_user']),
            HourAdjustmentStateFactory::create($record['code'], $record['id'])
        );

        return $entity;
    }

    public function findFirst()
    {
        throw new LogicException('Método não implementado');
    }

    /**
     * @param $entity Entities\UserHourAdjustmentStatus
     *
     * @return int
     */
    public function save($entity)
    {
        $query = "INSERT INTO " . $this->getTableName() . " " .
            "(id_status, id_user) VALUES (:id_status, :id_user)";
        $stm = $this->getPdo()->prepare($query);
        $stm->bindParam(':id_status', $entity->getHourAdjustmentStatus()->getId());
        $stm->bindParam(':id_user', $entity->getUser()->getId());
        $stm->execute();

        $id = $this->getPdo()->lastInsertId();

        return $id;
    }

    /**
     * @param $entity Entities\UserHourAdjustmentStatus
     */
    public function update($entity)
    {
        $query = "UPDATE " . $this->getTableName() . " " .
                 "SET id_status = :id_status" . " " .
                 "WHERE id_user = :id_user";
        $stm = $this->getPdo()->prepare($query);
        $stm->bindParam(':id_status', $entity->getHourAdjustmentStatus()->getId());
        $stm->bindParam(':id_user', $entity->getUser()->getId());
        $stm->execute();
    }

    protected function bindValues(PDOStatement $pdoStatement): PDOStatement
    {
        throw new LogicException('Método não implementado');
    }
}
