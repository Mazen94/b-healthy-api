<?php


namespace App\Repositories;

use App\Visit;
use Illuminate\Database\Eloquent\Model;


class VisitRepository
{
    protected $model;

    /**
     * RecommandationRepository constructor.
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Method to get all the visits related to a patient from database
     * @param $id
     * @return mixed
     */
    public function getAllVisits($id)
    {
        $patient = $this->model->patients()->findOrFail($id);
        return $patient->visits()->paginate();
    }

    /**
     * method to get only  one visit related to a patient
     *
     * @param $id_patient
     * @param $id_visit
     * @return mixed
     */
    public function getVisit($id_patient, $id_visit)
    {
        $patient = $this->model->patients()->findOrFail($id_patient);
        $visit = $patient->visits()->findOrFail($id_visit);
        return $visit;
    }

    /**
     * Method to update Visit related to patient
     *
     * @param $request
     * @param $id_patient
     * @param $id_visit
     * @return bool|false|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Eloquent\Relations\HasMany[]
     */
    public function updateVisit($request, $id_patient, $id_visit)
    {
        $patient = $this->model->patients()->findOrFail($id_patient);
        $visit = $patient->visits()->findOrFail($id_visit);
        $visit->poids = $request->poids;
        $visit->note = $request->note;
        $visit->scheduled_at = $request->scheduled_at;
        $visit->save();
        return $visit;
    }

    /**
     * Method to create a new visit related to patient
     *
     * @param $request
     * @param $id_patient
     * @return false|\Illuminate\Database\Eloquent\Model
     */
    public function createVisit($request, $id_patient)
    {
        $visit = new Visit();
        $visit->poids = $request->poids;
        $visit->note = $request->note;
        $visit->scheduled_at = $request->scheduled_at;
        $patient = $this->model->patients()->findOrFail($id_patient);

        return $patient->visits()->save($visit);
    }

    /**
     * Method to delete visit related to patient
     *
     * @param $id
     * @return bool|mixed|null
     * @throws \Exception
     */
    public function deleteVisit($id_patient, $id_visit)
    {
        $patient = $this->model->patients()->findOrFail($id_patient);
        $visit = $patient->visits()->findOrFail($id_visit);
        return $visit->delete();
    }
}
