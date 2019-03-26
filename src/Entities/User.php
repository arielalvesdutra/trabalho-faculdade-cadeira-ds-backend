<?php

namespace App\Entities;

use App\Entities\UserProfiles;
use InvalidArgumentException;
use OutOfRangeException;

/**
 * Entidade do Usuário do sistema.
 *
 * Class User
 * @package App\Entities
 */
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
     * @var string $password
     */
    protected $password;

    /**
     * @var UserProfiles\UserProfile[] $userProfiles
     */
    protected $userProfiles = [];

    /**
     * @param UserProfiles\UserProfile $profile
     */
    public function addProfile(UserProfiles\UserProfile $profile)
    {
        $this->userProfiles[$profile->getCode()] = $profile;
    }

    /**
     * @param array $profiles
     */
    public function addProfiles(array $profiles)
    {
        foreach ($profiles as $profile) {
            $this->addProfile($profile);
        }
    }

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
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $profileCode
     *
     * @return UserProfiles\UserProfile
     */
    public function getProfile(string $profileCode)
    {
        if (!empty($this->userProfiles[$profileCode])) {
            return $this->userProfiles[$profileCode];
        }

        throw new OutOfRangeException('O usuário não possui o perfil passado por parâmetro');
    }


    /**
     * @return UserProfiles\UserProfile[]
     */
    public function getProfiles()
    {
        return $this->userProfiles;
    }

    /**
     * @param string $email
     *
     * @return User
     */
    public function setEmail(string $email)
    {
        if (preg_match(self::EMAIL_REGEX, strtolower($email))) {

            $this->email = strtolower($email);
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

    /**
     * @param string $password
     *
     * @return $this
     */
    public function setPassword(string $password)
    {
        if (!empty($password)) {

            $this->password = $password;
            return $this;
        }

        throw new InvalidArgumentException("Parâmetro senha inválido.");
    }
}