<?php

namespace App\Entities;

use App\States\HourAdjustment;
use DomainException;

class UserHourAdjustmentStatus extends Entity
{
    /**
     * @var User $user
     */
    protected $user;

    /**
     * @var UserHourAdjustmentStatus $hourAdjustmentStatus
     */
    protected $hourAdjustmentStatus;

    public function getHourAdjustmentStatus()
    {
        return $this->hourAdjustmentStatus;
    }

    public function getId(): int
    {
        throw new DomainException('Essa entidade não possui ID');
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setHourAdjustmentStatus(HourAdjustment\State $state)
    {
        $this->hourAdjustmentStatus = $state;
        return $this;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }
}