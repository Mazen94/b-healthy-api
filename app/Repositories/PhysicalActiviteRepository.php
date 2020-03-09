<?php


namespace App\Repositories;


use App\Activitephysique;
use Illuminate\Database\Eloquent\Model;

class PhysicalActiviteRepository
{
    protected $model;

    /**
     * PatientRepository constructor.
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Method to create a new  Activity
     *
     *
     * @param $request
     *
     * @return false|\Illuminate\Database\Eloquent\Model
     */
    public function createActivity($request)
    {
        $activity = new Activitephysique();
        $activity->distance = $request['distance'];
        $activity->activite_type = $request['activite_type'];
        $activity->energy_burned = $request['energy_burned'];
        $activity->duration = $request['duration'];
        $this->model->physicalActivity()->save($activity);
        return $activity;
    }
    /**
     * Method to get all Activitys
     *
     * @return false|\Illuminate\Database\Eloquent\Model
     */
    public function getActivitys()
    {
        return $this->model->physicalActivity;
    }
}
