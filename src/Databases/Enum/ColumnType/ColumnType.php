<?php

namespace App\Databases\Enum\ColumnType;


abstract class ColumnType
{
    protected $type;

    public function getType() : string
    {
        if (empty($this->type)) {
            throw new Exception("Favor preencher o tipo da coluna");
        }

        return $this->type;
    }
}