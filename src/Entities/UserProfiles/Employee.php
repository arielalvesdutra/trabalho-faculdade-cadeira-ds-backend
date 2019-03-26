<?php

namespace App\Entities\UserProfiles;

/**
 * Classe de Perfil de Trabalhador
 *
 * Class CourseCoordinator
 * @package App\Entities\UserProfiles
 */
class Employee extends UserProfile
{
    const CODE = 'employee';

    /**
     * @var string $code
     */
    protected $code = self::CODE;
    /**
     * @var string $name
     */
    protected $name = "Trabalhador";
}