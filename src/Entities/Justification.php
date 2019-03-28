<?php

namespace App\Entities;

use InvalidArgumentException;

/**
 * Entidade de Justificativa de um Ajuste de Horas.
 *
 * Class Justification
 * @package App\Entities
 */
class Justification extends Entity
{
    /**
     * @var string $name
     */
    protected $name;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name)
    {
        if (!empty($name)) {
            $this->name = $name;
            return $this;
        }

        throw new InvalidArgumentException('O parametro nome é inválido.');
    }
}
