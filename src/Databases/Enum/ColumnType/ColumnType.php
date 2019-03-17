<?php

namespace App\Databases\Enum\ColumnType;


/**
 * Class ColumnType
 * @package App\Databases\Enum\ColumnType
 */
abstract class ColumnType
{
    /**
     * @var
     */
    protected $type;

    /**
     * @return string
     */
    public function getType() : string
    {
        if (empty($this->type)) {
            throw new Exception("Favor preencher o tipo da coluna");
        }

        return $this->type;
    }
}