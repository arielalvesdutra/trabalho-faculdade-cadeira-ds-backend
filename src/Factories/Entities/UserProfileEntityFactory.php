<?php
namespace App\Factories\Entities;

use App\Entities\UserProfiles;
use InvalidArgumentException;

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
     *
     * @param string $code
     * @param int|null $id
     * @return UserProfiles\CourseCoordinator |
     *         UserProfiles\Employee |
     *         UserProfiles\PedagogicalCoreCoordinator
     */
    public static function create(string $code, int $id = null)
    {
        if (!empty($code)) {

            if ($code === UserProfiles\PedagogicalCoreCoordinator::CODE) {
                return new UserProfiles\PedagogicalCoreCoordinator($id);
            }

            if ($code === UserProfiles\CourseCoordinator::CODE) {
                return new UserProfiles\CourseCoordinator($id);
            }

            if ($code === UserProfiles\Employee::CODE) {
                return new UserProfiles\Employee($id);
            }
        }

        throw new InvalidArgumentException('Código inválido de perfil de usuário!');
    }

    /**
     * @param array $profiles
     *
     * @return array
     */
    public static function createFromArrayOfProfiles(array $profiles)
    {

        $profilesArray = [];

        foreach ($profiles as $profile) {

            $profilesArray[] = UserProfileEntityFactory::create(
                    $profile['code']
            );
        }

        return $profilesArray;
    }
}
