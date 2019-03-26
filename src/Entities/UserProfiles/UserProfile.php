<?php

namespace App\Entities\UserProfiles;

use App\Entities\Entity;
use DomainException;

/**
 * Classe de Perfil de Usuário
 *
 * Class UserProfile
 * @package App\Entities\UserProfiles
 */
abstract class UserProfile extends Entity
{
    /**
     * @var string $code
     */
    protected $code;

    /**
     * @var string $name
     */
    protected $name;

    /**
     * @return string
     */
    public function getCode(): string
    {
        if (!empty($this->code)) {
            return $this->code;
        }

        throw new DomainException('Código de perfil de usuário não configurado.');
    }

    /**
     * @return string
     */
    public function getName(): string
    {

        if (!empty($this->name)) {
            return $this->name;
        }

        throw new DomainException('Nome de perfil de usuário não configurado.');
    }
}
