<?php
namespace App\Factories\Entities;

use App\Entities;

/**
 *
 * Classe para fabricar uma entidade usuário padrão do sistema
 * Class UserEntityFactory
 * @package App\Factories\Entities
 */
class UserEntityFactory
{

    /**
     * Método para criar uma entidade usuário padrão
     *
     * @param string $name
     * @param string $email
     * @param string $password
     * @param int|null $id
     *
     * @return Entities\User
     */
    public static function create(string $name, string $email,
                                  string $password, int $id = null): Entities\User
    {

        return (new Entities\User($id))
            ->setName($name)
            ->setEmail($email)
            ->setPassword($password);
    }
}