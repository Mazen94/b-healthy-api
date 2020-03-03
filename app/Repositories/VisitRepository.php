<?php


namespace App\Repositories;


use App\Nutritionist;
use App\Visit;


class VisitRepository
{
    protected $nutritionist;

    /**
     * PatientRepository constructor.
     * @param Nutritionist $nutritionist
     */
    public function __construct(Nutritionist $nutritionist)
    {
        $this->nutritionist = $nutritionist;
    }

    /**
     * Method to get all the visits related to a patient from database
     * @param $id
     * @return mixed
     */
    public function getAllVisits($id)
    {
        $patient = $this->nutritionist->patients()->findOrFail($id);
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
        $patient = $this->nutritionist->patients()->findOrFail($id_patient);
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
        $patient = $this->nutritionist->patients()->findOrFail($id_patient);
        $visit = $patient->visits()->findOrFail($id_visit);
        if ($visit) {
            return $visit->fill($request->all())->save();
        }
    }

    /**
     * Method to create a new visit
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
        $patient = $this->nutritionist->patients()->findOrFail($id_patient);

        return $patient->visits()->save($visit);
    }

    /**
     * Method to delete visit
     *
     * @param $id
     * @return bool|mixed|null
     * @throws \Exception
     */
    public function deleteVisit($id_patient, $id_visit)
    {
        $patient = $this->nutritionist->patients()->findOrFail($id_patient);
        $visit = $patient->visits()->findOrFail($id_visit);
        return $visit->delete();
    }
}
