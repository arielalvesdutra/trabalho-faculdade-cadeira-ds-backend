<?php

namespace Tests\Factories\Entities;

use App\Factories\Entities\UserEntityFactory;
use PHPUnit\Framework\TestCase;

/**
 * Testes Unitários para a classe App\Factories\Entities\UserEntityFactory
 *
 * Class UserEntityFactoryTest
 * @package Tests\Factories\Entities
 */
class UserEntityFactoryTest extends TestCase
{
    /**
     * Verifica se a classe existe
     *
     * Verifica se a classe extende App\Factories\Entities\EntityFactory
     */
    protected function assertPreConditions(): void
    {
        $this->assertTrue(
            class_exists('App\Factories\Entities\UserEntityFactory'),
            'Classe App\Factories\Entities\UserEntityFactory não encontrada.'
        );
    }

    /**
     * Testa o método estático create()
     */
    public function testCreateUserEntityShouldWork()
    {

        $userName = 'teste factory';
        $userEmail = "teste.factory@teste.com";
        $userPassword = '123456';

        $userEntity = UserEntityFactory::create(
          $userName,
          $userEmail ,
          $userPassword
        );

        $this->assertEquals(
          $userName,
          $userEntity->getName()
        );

        $this->assertEquals(
            $userEmail,
            $userEntity->getEmail()
        );

        $this->assertEquals(
            $userPassword,
            $userEntity->getPassword()
        );
    }
}