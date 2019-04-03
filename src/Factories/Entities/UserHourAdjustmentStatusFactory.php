<?php

namespace App\Factories\Entities;

use App\Entities;
use App\States\HourAdjustment;

class UserHourAdjustmentStatusFactory
{

    /**
     * @param Entities\User $user
     * @param HourAdjustment\State $state
     *
     * @return Entities\UserHourAdjustmentStatus
     */
    public static function create(Entities\User $user,
                                  HourAdjustment\State $state)
    {

        return (new Entities\UserHourAdjustmentStatus())
                ->setUser($user)
                ->setHourAdjustmentStatus($state);
    }
}