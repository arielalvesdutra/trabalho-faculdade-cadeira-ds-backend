<?php

namespace Tests\Repositories;

use App\Databases;
use App\Databases\Enum\ColumnType\IntType;
use App\Databases\Enum\ColumnType\VarcharType;
use App\Databases\Enum\MySQLEngine\InnoDb;
use App\Databases\Factories\Connections\DefaultDatabaseConnection;
use App\Models;
use App\Repositories;
use Exception;
use PHPUnit\Framework\TestCase;

/**
 * Testes Unitários para a classe App\Repositories\User
 *
 * Class UserTest
 * @package Tests\Repositories
 */
class UserTest extends TestCase
{
    /**
     * Ao iniciar o teste cria a tabela users_tests
     */
    public function setUp(): void
    {
        $this->createUserTestTable();
    }

    /**
     * Ao finalizar o teste remove a tabela users_tests
     */
    protected function tearDown(): void
    {
        $this->dropUserTestTable();
    }

    /**
     * Verifica se a classe existe
     */
    protected function assertPreConditions(): void
    {
        $this->assertTrue(
            class_exists('App\Repositories\User'),
            'Classe App\Repositories\User não encontrada.'
        );
    }

    /**
     * @todo 2.Validar os valores da entidade antes de salvar na model
     * @todo 3.Validar se existe usuário com o mesmo email
     */
    public function testCreateUserShouldWork()
    {
        $userName = 'teste repository';
        $userEmail = 'teste.repository.create@teste.com';
        $userPassword = '123456';

        $controllerParameters = [
            'name' => $userName,
            'email' => $userEmail,
            'password' => $userPassword
        ];

        $userRepository = new Repositories\User(
          new Models\User(
              DefaultDatabaseConnection::getConnection()
          )
        );

        $userRepository->setTestsEnvironment();

        $userRepository->createUser($controllerParameters);

        $userModel = new Models\User(
            DefaultDatabaseConnection::getConnection()
        );

        $userModel->setTableName("users_tests");
        
        $userEntity = $userModel->addFilters([ "email like " => "'". $userEmail . "'" ])->findFirst();

        $this->assertEquals(
            $userName,
            $userEntity->getName(),
            "Nome do usuário não conferem."
        );

        $this->assertEquals(
            $userEmail,
            $userEntity->getEmail(),
            "Email do usuário não conferem."
        );

        $this->assertEquals(
            $userPassword,
            $userEntity->getPassword(),
            "Senha do usuário não conferem."
        );
    }

    /**
     * @todo 1. criar dois usuários com o mesmo e-mail, o segundo usuário deve lançar uma exceção
     */
    public function testCreateUserWithDuplicateEmailShouldThrowAnException()
    {
        $this->expectException(Exception::class);

        $userName = 'User Duplicated Repository Test';
        $userEmail = 'teste.duplicated.repo@teste.com';
        $userPassword = 'password';

        $controllerParameters = [
            'name' => $userName,
            'email' => $userEmail,
            'password' => $userPassword
        ];

        $userRepository = new Repositories\User(
            new Models\User(
                DefaultDatabaseConnection::getConnection()
            )
        );

        $userRepository->createUser($controllerParameters);

        $userRepository->createUser($controllerParameters);
    }

    /**
     * Método para criar a tabala que será utilizada nos testes.
     *
     * @throws \Exception
     */
    private function createUserTestTable()
    {
        $database = new Databases\Database(
            new Databases\DatabaseServerConnection(
                $_ENV['MYSQL_HOST'],
                $_ENV['MYSQL_USER'],
                $_ENV['MYSQL_PASSWORD'],
                $_ENV['MYSQL_PORT'],
                $_ENV['MYSQL_DATABASE']
            )
        );

        $tableName = 'users_tests';
        $table = new Databases\Table($tableName);

        $table->addColumn((new Databases\Column('id', new IntType()))
            ->setNotNull()
            ->setAutoIncrement()
            ->setSize(12)
        );

        $table->addColumn((new Databases\Column('name', new VarcharType()))
            ->setNotNull()
            ->setSize(50)
        );

        $table->addColumn((new Databases\Column('email', new VarcharType()))
            ->setNotNull()
            ->setSize(50)
            ->setUnique()
        );

        $table->addColumn((new Databases\Column('password', new VarcharType()))
            ->setNotNull()
            ->setSize(50)
        );

        $table->addPrimaryKey($table->getColumns()['id']);
        $table->setEngine(new InnoDb());

        $database->createTableIfNotExists($table);
    }

    /**
     * Método para remover a tabela que será utilizada nos testes.
     */
    private function dropUserTestTable()
    {
        $database = new Databases\Database(
            new Databases\DatabaseServerConnection(
                $_ENV['MYSQL_HOST'],
                $_ENV['MYSQL_USER'],
                $_ENV['MYSQL_PASSWORD'],
                $_ENV['MYSQL_PORT'],
                $_ENV['MYSQL_DATABASE']
            )
        );

        $database->dropTable('users_tests');
    }
}