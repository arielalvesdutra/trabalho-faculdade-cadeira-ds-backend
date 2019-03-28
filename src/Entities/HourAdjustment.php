<?php

namespace App\Entities;

use DateInterval;
use DateTime;

/**
 * Entidade de um Ajuste de Horas.
 *
 * Class HourAdjustment
 * @package App\Entities
 */
class HourAdjustment extends Entity
{
    /**
     * @var DateTime $date
     */
    protected $date;

    /**
     * @var DateInterval $duration
     */
    protected $duration;

    /**
     * @var DateTime $entryHour
     */
    protected $entryHour;

    /**
     * @var DateTime $exitHour
     */
    protected $exitHour;

    /**
     * @var Justification $justification
     */
    protected $justification;

    /**
     * @return DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return DateInterval
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @return DateTime
     */
    public function getEntryHour()
    {
        return $this->entryHour;
    }

    /**
     * @return DateTime
     */
    public function getExitHour()
    {
        return $this->exitHour;
    }

    /**
     * @return Justification
     */
    public function getJustification()
    {
        return $this->justification;
    }

    /**
     * @param DateTime $date
     *
     * @return $this
     */
    public function setDate(DateTime $date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @param DateInterval $duration
     *
     * @return $this
     */
    public function setDuration(DateInterval $duration)
    {
        $this->duration = $duration;
        return $this;
    }

    /**
     * @param DateTime $entryHour
     *
     * @return $this
     */
    public function setEntryHour(DateTime $entryHour)
    {
        $this->entryHour = $entryHour;
        return $this;
    }

    /**
     * @param DateTime $exitHour
     *
     * @return $this
     */
    public function setExitHour(DateTime $exitHour)
    {
        $this->exitHour = $exitHour;
        return $this;
    }

    /**
     * @param Justification $justification
     *
     * @return $this
     */
    public function setJustification(Justification $justification)
    {
        $this->justification = $justification;
        return $this;
    }
}
