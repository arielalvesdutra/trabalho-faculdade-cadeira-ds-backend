<?php

namespace Tests\Databases\Factories\Connections;

use App\Databases\Factories\Connections;
use PDO;
use PHPUnit\Framework\TestCase;

/**
 * Testes Unitários para a classe App\Databases\Factories\Connections\DefaultDatabaseConnection
 *
 * Class DefaultDatabaseConnectionTest
 * @package App\Databases
 */
class DefaultDatabaseConnectionTest extends TestCase
{

    /**
     * Verifica se a classe existe
     */
    protected function assertPreConditions(): void
    {
        $this->assertTrue(
            class_exists('App\Databases\Factories\Connections\DefaultDatabaseConnection'),
            'Classe App\Databases\Factories\Connections\DefaultDatabaseConnection não encontrada.'
        );
    }

    /**
     * Testa se o método método estático getConnection() retorna
     * uma conexão PDO
     */
    public function testGetConnectionShouldWork()
    {

        $connection = Connections\DefaultDatabaseConnection::getConnection();

        $this->assertInstanceOf(PDO::class, $connection,
            "Não foi retornada um conexão com o banco de dados.");
    }
}