<?php

namespace App\Models;

use App\Entities;
use App\Exceptions\NotFoundException;
use PDO;
use PDOStatement;

class UsersProfiles extends Model
{
    protected $tableName = 'users_user_profiles';

    /**
     * Método para adicionar os filtros pare realiza consulta dos
     * registros no banco de dados
     *
     * @param array $filters
     *
     * @return mixed
     */
    public function addFilters(array $filters)
    {
        // TODO: Implement addFilters() method.
    }

    /**
     * @return mixed
     */
    public function find()
    {
        // TODO: Implement find() method.
    }

    /**
     * @return mixed
     */
    public function findFirst()
    {
        // TODO: Implement findFirst() method.
    }

    /**
     * @param Entities\User $userEntity
     *
     * @return mixed|void
     */
    public function save($userEntity)
    {
        $query = "INSERT INTO " . $this->getTableName() ." " .
                 "(id_user, id_user_profile) VALUES (:id_user, :id_user_profile)";

        $stm = $this->getPdo()->prepare($query);
        $stm->bindParam(':id_user', $userEntity->getId());

        foreach ($userEntity->getProfiles() as $profile) {
            $stm->bindParam(':id_user_profile', $profile->getId());
            $stm->execute();
        }
    }

    /**
     * @param $entity
     *
     * @return mixed
     */
    public function update($entity)
    {
        // TODO: Implement update() method.
    }

    /**
     * Realiza a ligação dos parametros a uma operação com o PDO
     * a ser realizada
     *
     * @param PDOStatement $pdoStatement
     *
     * @return PDOStatement
     */
    protected function bindValues(PDOStatement $pdoStatement): PDOStatement
    {
        // TODO: Implement bindValues() method.
    }
}