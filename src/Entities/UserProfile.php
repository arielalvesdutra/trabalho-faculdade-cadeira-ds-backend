<?php

namespace App\Entities;

use DomainException;
use InvalidArgumentException;

/**
 * Classe de Perfil de Usuário
 *
 * Class UserProfile
 * @package App\Entities\UserProfiles
 */
class UserProfile extends Entity
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

    /**
     * @param string $code
     *
     * @return $this
     */
    public function setCode(string $code)
    {
        if(!empty($code)) {
            $this->code = $code;
            return $this;
        }

        throw new InvalidArgumentException('Parametro código é inválido.');
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name)
    {
        if(!empty($name)) {
            $this->name = $name;
            return $this;
        }

        throw new InvalidArgumentException('Parametro nome é inválido.');
    }
}