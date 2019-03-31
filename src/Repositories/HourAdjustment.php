<?php

namespace App\Repositories;

use App\Databases\Factories\Connections\DefaultDatabaseConnection;
use App\Entities;
use App\Exceptions\ForbiddenException;
use App\Exceptions\NotFoundException;
use App\Factories\Entities\HourAdjustmentEntityFactory;
use App\Formatters\HourAdjustmentFormatter;
use App\Models;
use OutOfRangeException;

/**
 * Repository de Ajustes de Horas
 *
 * Class HourAdjusment
 * @package App\Repositories
 */
class HourAdjustment
{
    /**
     * @var Models\HourAdjustment $model
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
            $justificationModel->findById($parameters['justification']['id']),
            $userModel->findById($parameters['userId'])
        );

        $this->model->save($hourAdjustmentEntity);
    }

    /**
     * @param array $parameters
     *
     * @throws ForbiddenException
     * @throws NotFoundException
     */
    public function deleteHourAdjustment(array $parameters)
    {
        $adjustmentEntity = $this->model->findById($parameters['id_adjustment']);

        if ($adjustmentEntity->getUserId() != (int)$parameters['id_user']) {
            throw new ForbiddenException('Sem permissão para excluir o ajuste.');
        }

        $this->model->delete($adjustmentEntity->getId());
    }

    /**
     * @param array $parameters
     *
     * @return array
     *
     * @throws NotFoundException
     * @throws OutOfRangeException
     */
    public function retrieveEmployeeAdjustments(array $parameters)
    {
        $userModel = new Models\User(
            DefaultDatabaseConnection::getConnection()
        );

        $userProfilesModel = new Models\UserProfile(
            DefaultDatabaseConnection::getConnection()
        );

        $userEntity = $userModel->findById($parameters['id_user']);

        $userEntity->addProfiles(
            $userProfilesModel->findUserProfilesByUserId($userEntity->getId())
        );

        $employeeEntity = new Entities\UserProfiles\Employee();

        $userEntity->getProfile($employeeEntity->getCode());

        $hoursAdjustments = $this->model->findAdjustmentsByUserId($userEntity->getId());

        return HourAdjustmentFormatter::fromEntityArrayToControllerArray($hoursAdjustments);
    }

    /**
     * @param array $parameters
     *
     * @throws ForbiddenException
     * @throws NotFoundException
     */
    public function updateHourAdjustment(array $parameters)
    {

        $justificationModel = new Models\Justification(
            DefaultDatabaseConnection::getConnection()
        );

        $userModel = new Models\User(
            DefaultDatabaseConnection::getConnection()
        );

        $fetchEntity = $this->model->findById($parameters['id_adjustment']);

        if ($fetchEntity->getUserId() != (int)$parameters['id_user']) {
            throw new ForbiddenException('Sem permissão para atualizar o ajuste.');
        }

        $adjustmentEntity = HourAdjustmentEntityFactory::create(
            $parameters['date'],
            $parameters['entryHour'],
            $parameters['exitHour'],
            $justificationModel->findById($parameters['justification']['id']),
            $userModel->findById($parameters['id_user']),
            $parameters['id_adjustment']
        );

        $this->model->update($adjustmentEntity);
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