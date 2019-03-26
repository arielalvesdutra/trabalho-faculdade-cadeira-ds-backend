<?php

namespace App\Databases\Factories\Tables;

use App\Databases;
use App\Databases\Enum\ColumnType\IntType;
use App\Databases\Enum\ColumnType\VarcharType;
use App\Databases\Enum\MySQLEngine\InnoDb;

/**
 *
 * Class UserProfileTableTable
 * @package App\Databases\Factories\Tables
 */
class UsersUserProfilesTable implements  TableFactoryInterface
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

        $tableName = 'users_user_profiles';
        $table = new Databases\Table($tableName);

        $table->addColumn((new Databases\Column('id_user', new IntType()))
            ->setNotNull()
            ->setSize(12)
        );

        $table->addColumn((new Databases\Column('id_user_profile', new IntType()))
            ->setNotNull()
            ->setSize(12)
        );

        $table->addPrimaryKey($table->getColumns()['id_user']);
        $table->addPrimaryKey($table->getColumns()['id_user_profile']);

        $table->addForeignKey($table->getColumns()['id_user'], 'users(id)');
        $table->addForeignKey($table->getColumns()['id_user_profile'], 'user_profiles(id)');

        $table->setEngine(new InnoDb());

        $database->createTableIfNotExists($table);
    }
}