<?php

namespace App\Entities\UserProfiles;

/**
 * Classe de Perfil de Coordenador do Núcleo Pedagógico
 *
 * Class PedagogicalCoreCoordinator
 * @package App\Entities\UserProfiles
 */
class PedagogicalCoreCoordinator extends UserProfile
{

    const CODE = 'coordinator_of_pedagogical_core';

    /**
     * @var string $code
     */
    protected $code = self::CODE;

    /**
     * @var string $name
     */
    protected $name = "Coordenador de Núcleo Pedagógico";
}