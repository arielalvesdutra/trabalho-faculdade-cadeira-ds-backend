<?php
namespace App\Factories\Entities;

use App\Entities;
use DateTime;

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
     * @param int|null $id
     *
     * @return Entities\HourAdjustment
     *
     * @throws \Exception
     */
    public static function create(string $date, string $entryHour, string $exitHour,
                                  Entities\Justification $justification, int $id = null): Entities\HourAdjustment
    {

        $dateTime = new DateTime($date);
        $entryHourDateTime = new DateTime($date . " " .$entryHour);
        $exitHourDateTime = new DateTime($date . " " .$exitHour);
        $duration = $exitHourDateTime->diff($entryHourDateTime);

        return (new Entities\HourAdjustment($id))
                ->setDate(new DateTime($dateTime))
                ->setEntryHour($entryHourDateTime)
                ->setExitHour($exitHourDateTime)
                ->setDuration($duration)
                ->setJustification($justification);
    }
}