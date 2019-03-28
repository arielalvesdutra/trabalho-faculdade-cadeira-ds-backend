<?php

namespace App\Repositories;

use App\Databases\Factories\Connections\DefaultDatabaseConnection;
use App\Exceptions\NotFoundException;
use App\Factories\Entities\UserEntityFactory;
use App\Factories\Entities\UserProfileEntityFactory;
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

            $userId = $this->model->save($userEntity);
            $userEntity->setId($userId);

            if (!empty($parameters['userProfiles'])) {

                $userProfileModel = new Models\UserProfile(DefaultDatabaseConnection::getConnection());
                $usersProfilesModel = new Models\UsersProfiles(DefaultDatabaseConnection::getConnection());

                foreach ($parameters['userProfiles'] as $userProfile) {


                    $userEntity->addProfile(
                        $userProfileModel->findUserProfileByCode($userProfile['code'])
                    );
                }

                $usersProfilesModel->save($userEntity);
            }
        }
    }

    /**
     * @return array
     *
     * @throws NotFoundException
     */
    public function retrieveAllUsers()
    {
        $users = $this->model->find();
        $userProfileModel = new Models\UserProfile(DefaultDatabaseConnection::getConnection());

        foreach ($users as $key => $user) {
            try {

                $user->addProfiles(
                    $userProfileModel->findUserProfilesByUserId($user->getId())
                );

                $users[$key] = $user;
            } catch (NotFoundException $exception){
                // não precisar fazer nada
            }
        }

        return objectToArray($users);
    }
    /**
     * @param $id
     *
     * @return array
     *
     * @throws NotFoundException
     */
    public function retrieveUser($id)
    {
        $userEntity = $this->model->addFilters([ 'id = ' => $id])->findFirst();
        $userProfileModel = new Models\UserProfile(DefaultDatabaseConnection::getConnection());

        try {

            $userEntity->addProfiles(
                $userProfileModel->findUserProfilesByUserId($userEntity->getId())
            );
        } catch (NotFoundException $exception){
            // não precisar fazer nada
        }

        return objectToArray($userEntity);
    }

    /**
     * @param array $parameters
     *
     * @return array
     *
     * @throws NotFoundException
     */
    public function retrieveUserByEmailAndPassword(array $parameters)
    {
        if (empty($parameters['email'])) {
            throw new Exception('Email está vazio');
        }

        if (empty($parameters['password'])) {
            throw new Exception('Senha está vazia');
        }

        $userProfileModel = new Models\UserProfile(DefaultDatabaseConnection::getConnection());

        $userEntity = $this->model->addFilters([
            "email = '" => $parameters['email'] ."'",
            "password = '" => $parameters['password'] ."'"
        ])->findFirst();

        $userEntity->addProfiles(
            $userProfileModel->findUserProfilesByUserId($userEntity->getId())
        );

        return objectToArray($userEntity);
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