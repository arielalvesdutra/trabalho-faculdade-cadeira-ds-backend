<?php

namespace App\Repositories;

use App\Exceptions\NotFoundException;
use App\Factories\Entities\UserProfileEntityFactory;
use App\Models;
use Exception;

class UserProfile
{
    /**
     * @var Models\UserProfile
     */
    protected $model;

    /**
     * UserProfile constructor.
     * @param Models\UserProfile $model
     */
    public function __construct(Models\UserProfile $model)
    {
        $this->model = $model;
    }


    /**
     * @param array $parameters
     */
    public function createUserProfile(array $parameters)
    {
        $userProfileEntity = UserProfileEntityFactory::create(
          $parameters['name'],
          $parameters['code']
        );

        try {

            $fetchedUserProfile = $this->model->addFilters([
                "code like '" => $userProfileEntity->getCode()  ."'"
            ])->findFirst();

            if (!empty($fetchedUserProfile)) {
                throw new Exception('Já existe um perfil de usuário com o mesmo código.');
            }

        } catch (NotFoundException $exception) {

            $this->model->save($userProfileEntity);
        }
    }
}