<?php

namespace App\Repositories;

use App\Databases\Factories\Connections\DefaultDatabaseConnection;
use App\Exceptions\NotFoundException;
use App\Factories\Entities\HourAdjustmentEntityFactory;
use App\Models;
use Exception;

/**
 * Repository de Usuários
 *
 * Class HourAdjusment
 * @package App\Repositories
 */
class HourAdjusment
{
    /**
     * @var Models\User $model
     */
    protected $model;

    /**
     * User constructor.
     * @param Models\HourAdjustment $model
     */
    public function __construct(Models\HourAdjustment $model)
    {
        $this->model = $model;
    }

    /**
     * @param array $parameters
     *
     * @throws NotFoundException
     */
    public function createHourAdjustment(array $parameters)
    {
        $justificationModel = new Models\Justification(
            DefaultDatabaseConnection::getConnection()
        );

        $userModel = new Models\User(
            DefaultDatabaseConnection::getConnection()
        );

        $hourAdjustmentEntity = HourAdjustmentEntityFactory::create(
            $parameters['date'],
            $parameters['entryHour'],
            $parameters['exitHour'],
            $justificationModel->findById($parameters['id_justification']),
            $userModel->findById($parameters['id_user'])
        );

        $this->model->save($hourAdjustmentEntity);
    }

    /**
     * Método para adicionar "_tests" na tabela de model da repository
     * para que a model interfira nos dados de um tabela de testes
     */
    public function setTestsEnvironment()
    {
        $this->model->setTableName(
          $this->model->getTableName() . "_tests"
        );

        return $this;
    }
}