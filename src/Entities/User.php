<?php

namespace App\Entities;

use InvalidArgumentException;

class User extends Entity
{
    const EMAIL_REGEX = "/^([a-z0-9.]{1,})([@])([a-z0-9]{1,})([.])([a-z0-9.]{1,})([a-z]{1})$/";

    /**
     * @var string $email
     */
    protected $email;

    /**
     * @var string $name
     */
    protected $name;

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email)
    {
        if (preg_match(self::EMAIL_REGEX, $email)) {

            $this->email = $email;
            return $this;
        }

        throw new InvalidArgumentException("Parametro e-mail inválido.");
    }

    /**
     * @param string $name
     *
     * @return User
     */
    public function setName(string $name)
    {
        if(!empty($name)) {

            $this->name = $name;
            return $this;
        }

        throw new InvalidArgumentException("Parâmeto nome inválido.");
    }
}