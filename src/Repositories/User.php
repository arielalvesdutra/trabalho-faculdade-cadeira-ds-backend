<?php

namespace App\Repositories;

use App\Exceptions\NotFoundException;
use App\Factories\Entities\UserEntityFactory;
use App\Models;
use Exception;

/**
 * Repository de Usuários
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
     *
     * @throws Exception
     */
    public function createUser(array $parameters)
    {
        $userEntity = UserEntityFactory::create(
            $parameters['name'],
            $parameters['email'],
            $parameters['password']
        );

        try {

            $fetchedUser = $this->model->addFilters([
                "email like '" => $userEntity->getEmail()  ."'"
            ])->findFirst();

            if (!empty($fetchedUser)) {
                throw new Exception('Já existe um usuário com o mesmo e-mail.');
            }

        } catch (NotFoundException $exception) {

            $this->model->save($userEntity);
        }
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