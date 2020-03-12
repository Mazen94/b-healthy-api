<?php


namespace App\Repositories;


use App\Activitephysique;
use App\Patient;
use Illuminate\Database\Eloquent\Model;

class PhysicalActiviteRepository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Method to create a new  Activity
     *
     *
     * @param int $distance
     * @param $activityType
     * @param int $energyBurned
     * @param int $duration
     *
     * @return false|\Illuminate\Database\Eloquent\Model
     */
    public function createActivity($distance, $activityType, $energyBurned, $duration)
    {
        $activity = new Activitephysique();
        $activity->distance = $distance;
        $activity->activite_type = $activityType;
        $activity->energy_burned = $energyBurned;
        $activity->duration = $duration;
        $this->model->physicalActivity()->save($activity);
        return $activity;
    }

}
