<?php

namespace App\Formatters;

use App\Entities;

class HourAdjustmentFormatter extends Formatter
{
    /**
     * @param $entities Entities\HourAdjustment[]
     *
     * @return array
     */
    public static function fromEntityArrayToControllerArray($entities)
    {
        $controllerArray = [];

        foreach ($entities as $entity) {
            $controllerArray[] = [
                'id' => $entity->getId(),
                'date' => $entity->getDate()->format('Y-m-d'),
                'entryHour' => $entity->getEntryHour()->format('H:i:s'),
                'exitHour' => $entity->getExitHour()->format('H:i:s'),
                'duration' => $entity->getDuration()->format('%h:%I'),
                'justification' =>  [
                  'id' => $entity->getJustification()->getId()
                ],
                'userId' => $entity->getUserId()
            ];
        }

        return $controllerArray;
    }
}
