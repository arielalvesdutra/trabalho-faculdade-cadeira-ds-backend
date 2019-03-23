<?php
namespace App\Factories\Entities;

use App\Entities;

/**
 *
 * Classe para fabricar uma entidade de perfil usuário
 * Class UserProfileEntityFactory
 * @package App\Factories\Entities
 */
class UserProfileEntityFactory
{

    /**
     * Método para criar uma entidade de perfil usuário
     * @param string $name
     * @param string $code
     * @param int|null $id
     *
     * @return Entities\UserProfile
     */
    public static function create(string $name, string $code, int $id = null)
    {
        return (new Entities\UserProfile($id))
            ->setName($name)
            ->setCode($code);
    }
}