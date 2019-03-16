<?php

namespace App\Databases\Factories\Databases;

use App\Databases;

/**
 * Class HourAdjustmentSystemDatabase
 * @package App\Databases\Factories\Databases
 */
class HourAdjustmentSystemDatabase implements DatabaseFactoryInterface
{
    public function __construct()
    {
        if (empty($_ENV['MYSQL_HOST'])) {
            throw new Exception("Favor preencher o campo MYSQL_HOST no arquivo '.env'.");
        }

        if (empty($_ENV['MYSQL_PORT'])) {
            throw new Exception("Favor preencher o campo MYSQL_PORT no arquivo '.env'.");
        }

        if (empty($_ENV['MYSQL_USER'])) {
            throw new Exception("Favor preencher o campo MYSQL_USER no arquivo '.env'.");
        }

        if (empty($_ENV['MYSQL_PASSWORD'])) {
            throw new Exception("Favor preencher o campo MYSQL_PASSWORD no arquivo '.env'.");
        }
    }

    public static function create()
    {
        $databaseServerConnection =  new Databases\DatabaseServerConnection(
            $_ENV['MYSQL_HOST'],
            $_ENV['MYSQL_USER'],
            $_ENV['MYSQL_PASSWORD'],
            $_ENV['MYSQL_PORT']
        );

        $databaseServerConnection->createDatabaseIfNotExists($_ENV['MYSQL_DATABASE']);
    }
}
