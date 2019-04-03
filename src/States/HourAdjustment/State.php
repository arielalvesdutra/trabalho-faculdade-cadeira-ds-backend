<?php

namespace App\States\HourAdjustment;

use DomainException;

abstract class State
{
    protected $id;

    protected $code;

    protected $name;

    public function __construct(int $id = null)
    {
        $this->id = $id;
    }

    public function getCode()
    {
        if (!empty($this->code)) {
            return $this->code;
        }

        return new DomainException('Código não configurado');
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        if (!empty($this->name)) {
            return $this->name;
        }

        return new DomainException('Nome não configurado');
    }
}