<?php

namespace App\Databases\Enum\MySQLEngine;

/**
 * Class MySQLEngine
 * @package App\Databases\Enum\MySQLEngine
 */
abstract class MySQLEngine
{
    /**
     * @var string $engine
     */
    protected $engine;

    /**
     * @return mixed
     */
    public function getEngine()
    {
        if (empty($this->engine)) {
            throw new Exception("Favor preencher o nome da engine.");
        }

        return $this->engine;
    }
}