<?php

namespace Tests\Models;

use App\Models;
use App\Databases;
use App\Databases\Enum\ColumnType\IntType;
use App\Databases\Enum\ColumnType\VarcharType;
use App\Databases\Enum\MySQLEngine\InnoDb;
use App\Databases\Factories\Connections\DefaultDatabaseConnection;
use App\Entities;
use Exception;
use PHPUnit\Framework\TestCase;

/**
 * Testes Unitários para a classe App\Models\User
 *
 * Class UserTest
 * @package Tests\Models
 */
class UserTest extends TestCase
{
    /**
     * Cria a tabela de teste antes do teste
     *
     * @throws \Exception
     */
    protected function setUp(): void
    {
        $this->createUserTestTable();
    }

    /**
     * Remove a talela de teste após o teste
     */
    protected function tearDown(): void
    {
        $this->dropUserTestTable();
    }

    /**
     * Verifica se a classe existe
     *
     * Verifica se a classe extende App\Models\Model
     */
    protected function assertPreConditions(): void
    {
        $this->assertTrue(
            class_exists('App\Models\User'),
            'Classe App\Models\User não encontrada.'
        );

        $this->assertEquals(
            get_parent_class('App\Models\User'),
            'App\Models\Model',
            'A classe deve ter extender a App\Models\Model.'
        );
    }

    /**
     * Testa o método save() e o método find()
     */
    public function testSaveAndFindShouldWork()
    {
        $userEntity = (new Entities\User())
            ->setName("Teste find")
            ->setEmail("teste.find@teste.com")
            ->setPassword("123456");

        $userModel = new Models\User(
            DefaultDatabaseConnection::getConnection()
        );

        $userModel->setTableName("users_test_table");

        $id = $userModel->save($userEntity);

        $userResults = $userModel->addFilters([ 'id = ' => $id ])->find();

        $userEntity2 = $userResults[0];

        $this->assertInstanceOf(Entities\User::class, $userEntity2);

        $this->assertEquals(
            $userEntity->getName(),
            $userEntity2->getName(),
            'Nomes não conferem.'
        );

        $this->assertEquals(
            $userEntity->getEmail(),
            $userEntity2->getEmail(),
            'E-mails não conferem.'
        );

        $this->assertEquals(
            $userEntity->getPassword(),
            $userEntity2->getPassword(),
            'Senhas não conferem.'
        );
    }

    /**
     * Testa o método save() e o método findFirst()
     */
    public function testSaveAndFindFirstShouldWork()
    {
        $userEntity = (new Entities\User())
            ->setName("Teste findFirst")
            ->setEmail("teste.find.first@teste.com")
            ->setPassword("123456");

        $userModel = new Models\User(
            DefaultDatabaseConnection::getConnection()
        );

        $userModel->setTableName("users_test_table");

        $id = $userModel->save($userEntity);

        $userEntity2 = $userModel->addFilters([ 'id = ' => $id ])->findFirst();

        $this->assertInstanceOf(Entities\User::class, $userEntity2);

        $this->assertEquals(
            $userEntity->getName(),
            $userEntity2->getName(),
            'Nomes não conferem.'
        );

        $this->assertEquals(
            $userEntity->getEmail(),
            $userEntity2->getEmail(),
            'E-mails não conferem.'
        );

        $this->assertEquals(
            $userEntity->getPassword(),
            $userEntity2->getPassword(),
            'Senhas não conferem.'
        );
    }

    /**
     * Teste o método delete()
     *
     * @throws Exception
     */
    public function testDeleteShouldWorkAndThrowAnException()
    {
        $this->expectException(Exception::class);

        $userEntity =  (new Entities\User())
                ->setName("Teste delete")
                ->setEmail("teste.delete@teste.com")
                ->setPassword("123456");

        $userModel = new Models\User(
            DefaultDatabaseConnection::getConnection()
        );

        $id = $userModel->save($userEntity);

        $userModel->delete($id);

        $userModel->addFilters([ "id = " => $id])->findFirst();
    }

    /**
     * Testa o método update()
     */
    public function testUpdateShouldWork()
    {
        $userEntity = (new Entities\User())
            ->setName("Teste")
            ->setEmail("teste.atualizacao@teste.com")
            ->setPassword("123456");

        $userModel = new Models\User(
            DefaultDatabaseConnection::getConnection()
        );

        $userModel->setTableName("users_test_table");

        $id = $userModel->save($userEntity);

        $userEntity2 = (new Entities\User($id))
                ->setName("teste de atualização")
                ->setEmail("teste.atualizacao@teste.com.br")
                ->setPassword("987abc");

        $userModel->update($userEntity2);

        $userEntity3 = $userModel->addFilters([ 'id = ' => $id])->findFirst();

        $this->assertEquals(
            $userEntity2->getName(),
            $userEntity3->getName(),
            'Nomes não conferem.'
        );

        $this->assertEquals(
            $userEntity2->getEmail(),
            $userEntity3->getEmail(),
            'E-mails não conferem.'
        );

        $this->assertEquals(
            $userEntity2->getPassword(),
            $userEntity3->getPassword(),
            'Senhas não conferem.'
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

        $tableName = 'users_test_table';
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

        $database->dropTable('users_test_table');
    }
}