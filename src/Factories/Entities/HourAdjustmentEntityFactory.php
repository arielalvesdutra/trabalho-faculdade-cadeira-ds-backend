<?php
namespace App\Factories\Entities;

use App\Entities;
use DateTime;
use DomainException;

/**
 *
 * Classe para fabricar uma entidade Ajuste de Horas
 * Class HourAdjustmentEntityFactory
 * @package App\Factories\Entities
 */
class HourAdjustmentEntityFactory
{

    /**
     * @param string $date
     * @param string $entryHour
     * @param string $exitHour
     * @param Entities\Justification $justification
     * @param Entities\User $user
     * @param int|null $id
     *
     * @return Entities\HourAdjustment
     *
     * @throws \Exception
     */
    public static function create(string $date, string $entryHour, string $exitHour,
                                  Entities\Justification $justification,
                                  Entities\User $user, int $id = null): Entities\HourAdjustment
    {

        $dateTime = new DateTime($date);
        $entryHourDateTime = new DateTime($date . " " .$entryHour);
        $exitHourDateTime = new DateTime($date . " " .$exitHour);

        if ($entryHourDateTime->getTimestamp() >
            $exitHourDateTime->getTimestamp()
        ) {
            throw new DomainException('O registro de entrada é maior que o registro de saída.');
        }

        $duration = $exitHourDateTime->diff($entryHourDateTime);

        return (new Entities\HourAdjustment($id))
                ->setDate($dateTime)
                ->setEntryHour($entryHourDateTime)
                ->setExitHour($exitHourDateTime)
                ->setDuration($duration)
                ->setJustification($justification)
                ->setUserId($user->getId());
    }
}