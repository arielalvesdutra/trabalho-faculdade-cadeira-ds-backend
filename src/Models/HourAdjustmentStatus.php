<?php

namespace App\Models;

use App\States\HourAdjustment;
use App\Exceptions\NotFoundException;
use App\Factories\States\HourAdjustmentStateFactory;
use LogicException;
use PDO;
use PDOStatement;

/**
 *
 * Class HourAdjustmentStatus
 * @package App\Models
 */
class HourAdjustmentStatus extends Model
{
    /**
     * @var string $tableName
     */
    protected $tableName = "hours_adjustments_status";


    public function addFilters(array $filters)
    {
        throw new LogicException('Método não implementado');
    }

    public function find()
    {
        throw new LogicException('Método não implementado');
    }

    public function findAll()
    {
        throw new LogicException('Método não implementado');
    }

    /**
     * @param string $code
     *
     * @return HourAdjustment\Created |
     *         HourAdjustment\WaitingCoordinatorApproval
     *
     * @throws NotFoundException
     */
    public function findByCode(string $code)
    {

        $query = "SELECT * FROM " . $this->getTableName() . " " .
                 "WHERE code = :code "   ;

        $stm = $this->getPdo()->prepare($query);
        $stm->bindParam(':code', $code);
        $stm->execute();
        $record = $stm->fetch(PDO::FETCH_ASSOC);

        if (empty($record)) {
            throw new NotFoundException('Status de Ajuste de Horas não encontrado.');
        }

        $entity = HourAdjustmentStateFactory::create($record['code'], $record['id']);

        return $entity;
    }

    public function findById($id)
    {
        throw new LogicException('Método não implementado');
    }

    public function findFirst()
    {
        throw new LogicException('Método não implementado');
    }


    public function save($entity)
    {
        throw new LogicException('Método não implementado');
    }

    public function update($entity)
    {
        throw new LogicException('Método não implementado');
    }

    protected function bindValues(PDOStatement $pdoStatement): PDOStatement
    {
        throw new LogicException('Método não implementado');
    }
}
