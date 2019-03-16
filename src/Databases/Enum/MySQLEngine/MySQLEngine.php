<?php


namespace App\Databases\Enum\MySQLEngine;

abstract class MySQLEngine
{
    protected $engine;

    public function getEngine()
    {
        if (empty($this->engine)) {
            throw new Exception("Favor preencher o nome da engine.");
        }

        return $this->engine;
    }
}