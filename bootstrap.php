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
HourAdjustmentSystemDatabase::create();
