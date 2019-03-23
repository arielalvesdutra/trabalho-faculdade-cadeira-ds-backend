<?php

namespace App\Databases\Factories\Tables;

use App\Databases;
use App\Databases\Enum\ColumnType\IntType;
use App\Databases\Enum\ColumnType\VarcharType;
use App\Databases\Enum\MySQLEngine\InnoDb;

/**
 * Classe para criar a tabela 'users' no banco de dados
 *
 * Class UserProfileTableTable
 * @package App\Databases\Factories\Tables
 */
class UserProfileTable implements  TableFactoryInterface
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

        $tableName = 'user_profiles';
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

        $table->addColumn((new Databases\Column('code', new VarcharType()))
            ->setNotNull()
            ->setSize(20)
            ->setUnique()
        );

        $table->addPrimaryKey($table->getColumns()['id']);
        $table->setEngine(new InnoDb());

        $database->createTableIfNotExists($table);
    }
}