<?php

namespace App\Databases;

use App\Databases\Enum\ColumnType\ColumnType;
use App\Databases\Enum\ColumnType\TextType;
use Exception;

/**
 * Essa classe representa uma coluna do banco de dados.
 *
 * Class Column
 * @package App\Database
 */
class Column
{

    /**
     * @var bool
     */
    protected $autoIncrement = false;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var bool
     */
    protected $notNull = false;

    /**
     * @var int
     */
    protected $size;

    /**
     * @var ColumnType
     */
    protected $type;

    /**
     * @var bool $unique
     */
    protected $unique = false;

    public function __construct(string $name, ColumnType $type)
    {
        $this->setName($name);
        $this->setType($type);
    }

    /**
     * @return bool
     */
    public function isAutoIncrement(): bool
    {
        return $this->autoIncrement;
    }

    /**
     * @return bool
     */
    public function isNotNull(): bool
    {
        return $this->notNull;
    }

    /**
     * @return bool
     */
    public function isUnique(): bool
    {
        return $this->unique;
    }

    /**
     * @return Column
     */
    public function setNotNull() : Column
    {
        $this->notNull = true;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return ColumnType
     */
    public function getType(): ColumnType
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @return Column
     */
    public function setAutoIncrement() : Column
    {
        $this->autoIncrement = true;
        return $this;
    }

    /**
     * Remove espaços do nome
     *
     * @param string $name
     */
    private function setName(string $name)
    {
        /**
         * @todo validar se não tem caracteres especiais
         * @todo validar se não começa ou termina com número, hifen ou underline
         */

        $this->name = trim($name);
    }

    /**
     * @param int $size
     *
     * @return Column
     *
     * @throws Exception
     */
    public function setSize(int $size) : Column
    {
        if ($this->getType() instanceof TextType) {
            throw new Exception('Não é possível setar o tamanho com o tipo Texto.');
        }

        $this->size = $size;
        return $this;
    }

    /**
     * @param ColumnType $columnType
     */
    private function setType(ColumnType $columnType)
    {
        $this->type = $columnType;
    }

    /**
     * @return $this
     */
    public function setUnique()
    {
        $this->unique = true;
        return $this;
    }

    public function __toString()
    {
        $size = $this->getSize()
            ?  "(" .$this->getSize(). ")"
            : '';

        $notNull = $this->isNotNull()
            ? " NOT NULL"
            : "";

        $autoIncrement = $this->isAutoIncrement()
            ? " AUTO_INCREMENT"
            : "";

        $unique = $this->isUnique()
            ? " UNIQUE"
            : "";

        return $this->getName() . " " .
               $this->getType()->getType() .
               $size .
               $notNull .
               $autoIncrement .
               $unique
            ;
    }
}