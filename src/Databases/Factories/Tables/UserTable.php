<?php

namespace App\Databases\Factories\Tables;

use App\Databases;
use App\Databases\Enum\ColumnType\IntType;
use App\Databases\Enum\ColumnType\VarcharType;
use App\Databases\Enum\MySQLEngine\InnoDb;

/**
 * Classe para criar a tabela 'users' no banco de dados
 *
 * Class UserTable
 * @package App\Databases\Factories\Tables
 */
class UserTable implements  TableFactoryInterface
{
    /**
     * @throws \Exception
     */
    public static function create()
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

        $tableName = 'users';
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
}