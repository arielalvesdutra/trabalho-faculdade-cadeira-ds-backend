<?php

namespace Tests\Controllers;

use App\Controllers;
use App\Repositories;
use App\Models;
use App\Databases;
use App\Databases\Enum\ColumnType\IntType;
use App\Databases\Enum\ColumnType\VarcharType;
use App\Databases\Enum\MySQLEngine\InnoDb;
use App\Databases\Factories\Connections\DefaultDatabaseConnection;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Environment;
use Slim\Http\Headers;
use Slim\Http\Request;
use Slim\Http\RequestBody;
use Slim\Http\Response;
use Slim\Http\Uri;

/**
 * Testes Unitários para a classe App\Controllers\Controller
 *
 * Class UserTest
 * @package Tests\Controllers
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
     *
     * Verifica se a classe extende App\Controllers\Controller
     */
    protected function assertPreConditions(): void
    {
        $this->assertTrue(
            class_exists('App\Controllers\User'),
            'Classe App\Controllers\User não encontrada.'
        );

        $this->assertEquals(
            get_parent_class('App\Controllers\User'),
            'App\Controllers\Controller',
            'A classe deve ter extender a App\Controllers\Controller.'
        );
    }

    /**
     * Teste para o método create()
     */
    public function testCreateUserShouldWork()
    {
        $name = "Create User Request";
        $email = "teste.create.user.req@teste.com";
        $password = "132456";

        $userController = new Controllers\User(
            (new Repositories\User(
              new Models\User(
                  DefaultDatabaseConnection::getConnection()
              )
          ))->setTestsEnvironment()
        );

        $requestParameters = [
            'name' => $name,
            'email' => $email,
            'password' =>  $password
        ];

        $response = $userController->create($this->createRequest(
            'POST',
            '/users',
            $requestParameters
        ),
            new Response()
        );

        $this->assertEquals(
          201,
          $response->getStatusCode(),
          "A menesagem HTTP deve ser 201"
        );

        $userModel = new Models\User(
            DefaultDatabaseConnection::getConnection()
        );
        $userModel->setTableName('users_tests');

        $userEntity = $userModel->addFilters([ "email =" => "'". $email ."'"])
                                ->findFirst();

        $this->assertEquals(
            $name,
            $userEntity->getName()
        );

        $this->assertEquals(
            $email,
            $userEntity->getEmail()
        );

        $this->assertEquals(
            $password,
            $userEntity->getPassword()
        );
    }

    /**
     * @todo 1. Deve retornar o status 400 caso a requisição esteja incorreta
     */
    public function testCreateUserWithBadRequestShouldReturn400HTTPMessage()
    {

    }

    /**
     * Testa o método retrieveAll()
     */
    public function testRetrieveAllUsersShouldWork()
    {
        $name = "Retrieve All Users Request";
        $email = "teste.retrive.all.users.req@teste.com";
        $password = "132456";

        $userController = new Controllers\User(
            (new Repositories\User(
                new Models\User(
                    DefaultDatabaseConnection::getConnection()
                )
            ))->setTestsEnvironment()
        );

        $createRequestParameters = [
            'name' => $name,
            'email' => $email,
            'password' =>  $password
        ];

        $userController->create($this->createRequest(
            'POST',
            '/users',
            $createRequestParameters
        ),
            new Response()
        );

        $response = $userController->retrieveAll($this->createRequest(
            'GET',
            '/users',
            []
        ),
            new Response()
        );

        $this->assertEquals(
            200,
            $response->getStatusCode(),
            "A menesagem HTTP deve ser 200"
        );

        $responseArray =  $this->getResponseBodyAsArray($response);

        $this->assertEquals(
          $name,
          $responseArray[0]['name']  ,
            'Os nomes não conferem.'
        );

        $this->assertEquals(
            $email,
            $responseArray[0]['email']  ,
            'Os emails não conferem.'
        );

        $this->assertEquals(
            $password,
            $responseArray[0]['password']  ,
            'As senhas não conferem.'
        );
    }

    /**
     * @todo 1.Deve retornar uma mensagem HTTP 200
     */
    public function testRetrieveUserShouldWork()
    {

    }

    /**
     * @todo
     */
    public function testRetrieveNotFoundUsersShouldReturn404HTTPMessage()
    {

    }

    /**
     * @todo
     */
    public function testRetrieveNotFoundUserShouldReturn404HTTPMessage()
    {

    }

    /**
     * @todo
     */
    public function testRetrieveUsersWithBadRequestShouldReturn400HTTPMessage()
    {

    }

    /**
     * @todo
     */
    public function testRetrieveUserWithBadRequestShouldReturn400HTTPMessage()
    {

    }

    /**
     * Cria um objeto Request para ser enviado para a controller
     *
     * @param string $method
     * @param string $uri
     * @param array $requestParameters
     *
     * @return Request
     */
    private function createRequest(string $method, string  $uri, array $requestParameters = []): Request
    {
        $env = Environment::mock([
            'REQUEST_URI' => $uri,
            'REQUEST_METHOD' => $method,
            'CONTENT_TYPE' => 'application/json;'
        ]);

        $body = new RequestBody();
        $body->write(json_encode($requestParameters));

        return new Request(
            $method,
            Uri::createFromEnvironment($env),
            Headers::createFromEnvironment($env),
            [],
            $env->all(),
            $body
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

    /**
     * @param ResponseInterface $response
     *
     * @return array
     */
    private function getResponseBodyAsArray(ResponseInterface $response)
    {
        $responseString = (string)$response->getBody();

        return json_decode($responseString, true);
    }

}