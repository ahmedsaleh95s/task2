<?php

namespace App\Repositories;
use App\Models\WorkingHour;

class WorkingHoursRepositories
{

    private $workingHour;

    public function __construct(WorkingHour $workingHour) {
        $this->var = $workingHour;
    }

    public function getWorkingHoursReservations($workingHours, $from, $to)
    {
        return $workingHours->reservations()
        ->where('from', '>=', $from) // >=
        ->where('to', '<=', $to) // <=
        ->count();
    }

}