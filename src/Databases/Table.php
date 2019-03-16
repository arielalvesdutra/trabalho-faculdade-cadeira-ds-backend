<?php

namespace App\Databases;

use App\Databases\Enum\ColumnType\IntType;
use App\Databases\Enum\MySQLEngine\MySQLEngine;
use Exception;

/**
 * Essa classe representa um tabela de banco de dados. Essa classe
 * é utilizada pela classe Database para criar novas tabelas no
 * banco de dados.
 *
 * Class Table
 * @package App\Database
 */
class Table
{
    /**
     * Array de colunas
     *
     * @var array<Column>
     */
    protected $columns = [];

    /**
     * @var MySQLEngine
     */
    protected $engine;

    /**
     * Array de chaves estrangeiras
     *
     * @var array<int>
     */
    protected $foreignKeys = [];

    /**
     * Array de chaves primárias
     *
     * @var array<int>
     */
    protected $primaryKeys = [];

    /**
     * @var string
     */
    protected $tableName;

    public function __construct(string $tableName)
    {
        $this->tableName = $tableName;
    }

    /**
     * Adiciona coluna ao array de colunas.
     *
     * O nome da coluna se torna o indice no array.
     *
     * @param Column $column
     */
    public function addColumn(Column $column)
    {
        $this->columns[$column->getName()] = $column;
    }

    /**
     * Adiciona coluna à chave primária
     *
     * A chave primária dever ser do tipo int
     *
     * @param Column $column
     *
     * @throws Exception
     */
    public function addPrimaryKey(Column $column)
    {
        if (!$column->getType() instanceof IntType) {
            throw new Exception("A chave primária deve ser do tipo inteiro.");
        }

        $this->primaryKeys[] = $column;
    }

    /**
     * @return array<Column>
     */
    public function getColumns() : array
    {
        return $this->columns;
    }

    public function getColumnsDDL() : string
    {
        $columnsDDL = '';
        $numberOfColumns = sizeof($this->getColumns());
        $count = 1;

        foreach ($this->getColumns() as $column) {

            if ($numberOfColumns == $count) {
                $columnsDDL .= $column->__toString();
            } else {
                $columnsDDL .= $column->__toString() . ', ';
                $count++;
            }
        }

        return $columnsDDL;
    }

    /**
     * @return MySQLEngine
     */
    public function getEngine(): MySQLEngine
    {
        return $this->engine;
    }

    private function getPrimaryKeys()
    {
        return $this->primaryKeys;
    }


    public function getPrimaryKey()
    {
        $numberOfColumns = sizeof($this->getPrimaryKeys());
        $count = 1;

        $primaryKeyDDL = 'PRIMARY KEY (';

        foreach ($this->getPrimaryKeys() as $key) {

            if ($numberOfColumns == $count) {
                $primaryKeyDDL .=  $key->getName();
            } else {
                $primaryKeyDDL .=  $key->getName() . ",";
                $count++;
            }
        }

        $primaryKeyDDL .= ")";

        return $primaryKeyDDL;
    }

    /**
     * @return string
     *
     * @throws Exception
     */
    public function getTableName()
    {
        if (empty($this->tableName)) {
            throw new Exception('O nome da tabela não foi configurado.');
        }

        return $this->tableName;
    }

    /**
     * @param MySQLEngine $engine
     */
    public function setEngine(MySQLEngine $engine)
    {
        $this->engine = $engine;
    }
}


