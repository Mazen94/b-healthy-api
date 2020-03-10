<?php


namespace App\Repositories;


use App\Activitephysique;
use App\Patient;
use Illuminate\Database\Eloquent\Model;

class PhysicalActiviteRepository
{

    /**
     * Method to create a new  Activity
     *
     *
     * @param Patient $patient
     * @param int $distance
     * @param string $activite_type
     * @param int $energy_burned
     * @param int $duration
     *
     * @return false|\Illuminate\Database\Eloquent\Model
     */
    public static function createActivity($patient,$distance,$activite_type,$energy_burned,$duration)
    {
        $activity = new Activitephysique();
        $activity->distance = $distance;
        $activity->activite_type = $activite_type;
        $activity->energy_burned = $energy_burned;
        $activity->duration = $duration;
        $patient->physicalActivity()->save($activity);
        return $activity;
    }

}
