<?php

namespace App\Repositories;

use App\Factories\Entities\UserEntityFactory;
use App\Models;

/**
 * Repository de usuários
 *
 * Class User
 * @package App\Repositories
 */
class User
{
    /**
     * @var Models\User $model
     */
    protected $model;

    /**
     * User constructor.
     * @param Models\User $model
     */
    public function __construct(Models\User $model)
    {
        $this->model = $model;
    }

    /**
     * @param array $parameters
     */
    public function createUser(array $parameters)
    {
        $userEntity = UserEntityFactory::create(
            $parameters['name'],
            $parameters['email'],
            $parameters['password']
        );

        $this->model->save($userEntity);
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