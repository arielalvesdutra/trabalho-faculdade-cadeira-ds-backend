<?php

namespace App\Databases\Factories\Connections;


interface DatabaseConnectionFactoryInterface
{
    public static function getConnection();
}