<?php

namespace App\Entities\UserProfiles;

use DomainException;
use InvalidArgumentException;

/**
 * Classe de Perfil de Coordenador de Curso
 *
 * Class CourseCoordinator
 * @package App\Entities\UserProfiles
 */
class CourseCoordinator extends UserProfile
{
    const CODE = 'course_coordinator';

    /**
     * @var string $code
     */
    protected $code = self::CODE;

    /**
     * @var string $name
     */
    protected $name = "Coordenador de Curso";
}