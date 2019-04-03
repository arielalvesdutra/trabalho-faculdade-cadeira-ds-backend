<?php

namespace App\States\HourAdjustment;

use DomainException;

class WaitingCoordinatorApproval extends State
{

    const CODE = 'waiting_coordinator_approval';

    protected $code = self::CODE;

    protected $name = 'Aguardando Aprovação do Coordenador de Curso.';
}