<?php


namespace App\Repositories;


use App\Nutritionist;
use App\Recommandation;


class RecommandationRepository
{
    protected $nutritionist;

    /**
     * RecommandationRepository constructor.
     * @param Nutritionist $nutritionist
     */
    public function __construct(Nutritionist $nutritionist)
    {
        $this->nutritionist = $nutritionist;
    }

    /**
     * Method to get all the recommandations related to patient from database
     *
     * @return mixed
     */
    public function getAllRecommendations($id)
    {
        $patient = $this->nutritionist->patients()->findOrFail($id);
        return $patient->recommandations;
    }

    /**
     * method to get only one recommendation related to patient
     * @param $id
     * @return array $data;
     */
    public function getRecommendation($patient_id, $id_recommendation)
    {
        $patient = $this->nutritionist->patients()->findOrFail($patient_id);
        return $patient->recommandations()->findOrFail($id_recommendation);
    }

    /**
     * Method to create a new recommendation related to patient
     *
     * @param $request
     *
     * @return false|\Illuminate\Database\Eloquent\Model
     */
    public function createRecommendation($request, $id_patient)
    {
        $patient = $this->nutritionist->patients()->findOrFail($id_patient);
        $rec = new Recommandation();
        $rec->avoid = $request['avoid'];
        $rec->save();
        $recommendation = $patient->recommandations()->attach($rec->id);

        return $rec;
    }

    /**
     * Method to update recommendation related to patient
     *
     * @param $request
     *
     * @return false|\Illuminate\Database\Eloquent\Model
     */
    public function updateRecommendation($request, $id_patient, $id_recommendation)
    {
        $patient = $this->nutritionist->patients()->findOrFail($id_patient);
        $recommendation = $patient->recommandations()->findOrFail($id_recommendation);
        $recommendation->avoid = $request['avoid'];
        $recommendation->save();

        return $recommendation;
    }

    /**
     * Method to delete recommendation related to patient
     *
     * @param $id
     * @return bool|mixed|null
     * @throws \Exception
     */
    public function deleteRecommendation($patient_id, $id_recommendation)
    {
        $patient = $this->nutritionist->patients()->findOrFail($patient_id);
        $recommendation = $patient->recommandations()->findOrFail($id_recommendation);
        return $recommendation->delete();
    }
}
