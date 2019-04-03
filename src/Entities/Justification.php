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
     * @var string $title
     */
    protected $title;

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return $this
     */
    public function setTitle(string $title)
    {
        if (!empty($title)) {
            $this->title = $title;
            return $this;
        }

        throw new InvalidArgumentException('O parametro title é inválido.');
    }
}
