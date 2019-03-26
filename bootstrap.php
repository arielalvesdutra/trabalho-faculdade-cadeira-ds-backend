<?php

require 'vendor/autoload.php';

/**
 * Método de Depuração
 */
function debug()
{
    $arguments = func_get_args();
    echo '<pre>';
    foreach($arguments as &$argument){
        if (is_object($argument) || is_array($argument)) {
            print_r($argument);
        } elseif (empty($argument) || is_resource($argument)) {
            var_dump($argument);
        } else {
            echo (string)$argument;
        }
    }
    echo '</pre>';
}

/**
 * Método de Depuração que encerra execução do código
 */
function debugd()
{
    $arguments = func_get_args();
    echo '<pre>';
    foreach($arguments as &$argument){
        if (is_object($argument) || is_array($argument)) {
            print_r($argument);
        } elseif (empty($argument) || is_resource($argument)) {
            var_dump($argument);
        } else {
            echo (string)$argument;
        }
    }
    echo '</pre>';
    die();
}

/**
 * Converte atributos publicos e protegidos de um objeto
 * para um array
 *
 * @param $data
 *
 * @return array
 */
function objectToArray($data)
{
    if (is_array($data)) {
        $result = [];

        foreach ($data as $key => $element) {
            $result[$key] = objectToArray($element);
        }

        return $result;
    }

    if (is_object($data)) {

        $result = [];
        $array = (array) $data;

        foreach ($array as $key => $element) {
            $formattedKey = str_replace(["*", "\0"],'', $key);
            $result[$formattedKey] = objectToArray($element);
        }

        return $result;
    }

    return $data;
}

/**
 * Método para setar os valores do arquivo .env na execução do PHP
 */
function setOnExecutionTimeEnvFileValues()
{

    $envFileValues = parse_ini_file('.env');

    foreach ($envFileValues as $key => $envFileValue) {
        $_ENV[$key] = $envFileValue;
    }
}

setOnExecutionTimeEnvFileValues();

use App\Databases\Factories\Databases\HourAdjustmentSystemDatabase;
use App\Databases\Factories\Tables\UserTable;
use App\Databases\Factories\Tables\UserProfileTable;
use App\Databases\Factories\Tables\UsersUserProfilesTable;

HourAdjustmentSystemDatabase::create();
UserTable::create();
UserProfileTable::create();
UsersUserProfilesTable::create();
