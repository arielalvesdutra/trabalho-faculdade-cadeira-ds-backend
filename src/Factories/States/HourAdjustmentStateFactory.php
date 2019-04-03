<?php


namespace App\Factories\States;

use App\States\HourAdjustment;
use InvalidArgumentException;

class HourAdjustmentStateFactory
{
    /**
     * @param string $code
     * @param int|null $id
     *
     * @return HourAdjustment\Created|HourAdjustment\WaitingCoordinatorApproval
     */
    public static function create(string $code, int $id = null)
    {
        if ($code == HourAdjustment\Created::CODE) {
            return new HourAdjustment\Created($id);
        }

        if ($code == HourAdjustment\WaitingCoordinatorApproval::CODE) {
            return new HourAdjustment\WaitingCoordinatorApproval($id);
        }

        throw new InvalidArgumentException('Código inválido de status de Ajuste de Hora!');
    }
}