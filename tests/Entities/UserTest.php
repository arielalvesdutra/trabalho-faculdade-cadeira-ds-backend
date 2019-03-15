<?php

namespace App\Entities;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @todo documentar
 *
 * Class UserTest
 * @package App\Entities
 */
class UserTest extends TestCase
{
    /**
     * Verifica se a classe existe
     *
     * Verifica se a classe extende App\Entities\Entity
     */
    protected function assertPreConditions(): void
    {
        $this->assertTrue(
            class_exists('App\Entities\User'),
            'Classe App\Entities\User não encontrada'
        );

        $this->assertEquals(
            get_parent_class('App\Entities\User'),
            'App\Entities\Entity',
            'A classe deve ter extender a App\Entities\Entity'
        );
    }

    /**
     * Testa os métodos setName() e getName()
     */
    public function testSetAndGetNameShouldWork()
    {
        $userName = "Teste";
        $user = new User();
        $user->setName($userName);

        $this->assertEquals($userName, $user->getName(), "Getter ou Setter do nome não está funcionando.");
    }

    /**
     * Testa o método setName() com um dado inválido e deve lançar
     * uma InvalidArgumentException
     */
    public function testSetNameWithInvalidDataShouldThrowAnInvalidArgumentException()
    {
        $this->expectException(InvalidArgumentException::class);

        $userName = "";

        $user = new User();
        $user->setName($userName);
    }

    /**
     * Testa o método setEmail() e getEmail()
     */
    public function testSetAndGetEmailShouldWork()
    {
        $email = "teste@teste.com";

        $user = new User();
        $user->setEmail($email);

        $this->assertEquals($email, $user->getEmail(), "Getter ou Setter do email não está funcionando");
    }

    /**
     * Testa o método setEmail() com um dado inválido e deve lançar
     * uma InvalidArgumentException
     */
    public function testSetEmailWithInvalidDataShouldThrowAnInvalidArgumentException()
    {
        $this->expectException(InvalidArgumentException::class);

        $userEmail = "email";

        $user = new User();
        $user->setEmail($userEmail);
    }

    /**
     * Testa o método setEmail() e getEmail()
     */
    public function testSetAndGetPasswordShouldWork()
    {
        $password = "password";

        $user = new User();
        $user->setPassword($password);

        $this->assertEquals($password, $user->getPassword(), "Getter ou Setter da senha não está funcionando");
    }

    /**
     * Testa o método setPassword() com um dado inválido e deve lançar
     * uma InvalidArgumentException
     */
    public function testSetPasswordWithInvalidDataShouldThrowAnInvalidArgumentException()
    {
        $this->expectException(InvalidArgumentException::class);

        $userPassword = "";

        $user = new User();
        $user->setPassword($userPassword);

    }
}