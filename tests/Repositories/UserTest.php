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
     * Testa o método createUser()
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
     * Testa o método createUser() e deve lançar uma exceção em
     * caso de se tentar criar uma usuário com um e-mail que
     * já existe na tabela
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

        $userRepository->setTestsEnvironment();

        $userRepository->createUser($controllerParameters);

        $userRepository->createUser($controllerParameters);
    }

    /**
     * Testa o método retrieve()
     *
     * @throws \App\Exceptions\NotFoundException
     */
    public function testRetrieveUserShouldWork()
    {

        $userName = 'User Retrive Repository Test';
        $userEmail = 'teste.retrive.repo@teste.com';
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

        $userRepository->setTestsEnvironment();

        $userRepository->createUser($controllerParameters);

        $id = 1;

        $fetchedUser = $userRepository->retrieveUser($id);

        $this->assertEquals(
          $userName,
          $fetchedUser['name'],
          'Os nomes não conferem.'
        );

        $this->assertEquals(
            $userEmail,
            $fetchedUser['email'],
            'Os emails não conferem.'
        );

        $this->assertEquals(
            $userPassword,
            $fetchedUser['password'],
            'As senhas não conferem.'
        );
    }

    /**
     * Testa o método retrieveAllUsers()
     *
     * @throws \App\Exceptions\NotFoundException
     */
    public function testRetrieveAllUsersShouldWork()
    {
        $userName = 'User Retrive All Repository Test';
        $userEmail = 'teste.retrive.all.repo@teste.com';
        $userPassword = 'password';

        $controllerParameters = [
            'name' => $userName,
            'email' => $userEmail,
            'password' => $userPassword
        ];

        $userRepository = (new Repositories\User(
            new Models\User(
                DefaultDatabaseConnection::getConnection()
            )
        ))->setTestsEnvironment();

        $userRepository->createUser($controllerParameters);

        $fetchedUsers = $userRepository->retrieveAllUsers();

        $this->assertEquals(
            $userName,
            $fetchedUsers[0]['name'],
            'Os nomes não conferem.'
        );

        $this->assertEquals(
            $userEmail,
            $fetchedUsers[0]['email'],
            'Os emails não conferem.'
        );

        $this->assertEquals(
            $userPassword,
            $fetchedUsers[0]['password'],
            'As senhas não conferem.'
        );
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