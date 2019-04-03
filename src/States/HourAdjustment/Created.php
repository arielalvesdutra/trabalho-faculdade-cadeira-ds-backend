<?php

namespace App\States\HourAdjustment;

use DomainException;

class Created extends State
{
    const CODE = 'created';

    protected $code = self::CODE;

    protected $name = 'Ajuste Criado.';
}