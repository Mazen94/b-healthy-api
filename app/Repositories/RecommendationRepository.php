<?php


namespace App\Repositories;

use App\Patient;
use App\Recommandation;
use Illuminate\Database\Eloquent\Model;

class RecommendationRepository
{
    /**
     * Method for nutritionist to create a new recommendation related to patient
     *
     * @param Patient $patient
     * @param string $avoid
     * @return false|Model
     */
    public function createRecommendation($patient, $avoid)
    {
        $recommendation = new Recommandation();
        $recommendation->avoid = $avoid;
        $recommendation->save();
        $patient->recommendations()->attach($recommendation->id);
        return $recommendation;
    }

    /**
     * Method for nutritionist to update recommendation related to patient
     *
     * @param Recommandation $recommendation
     * @param string $avoid
     *
     * @return false|Model
     */
    public function updateRecommendation($recommendation, $avoid)
    {
        $recommendation->avoid = $avoid;
        $recommendation->save();
        return $recommendation;
    }

    /**
     * Method for nutritionist to delete recommendation related to patient
     *
     * @param Recommandation $recommendation
     * @throws \Exception
     */
    public function deleteRecommendation($recommendation)
    {
        $recommendation->delete();
    }

    /**
     * Method for nutritionist to add menu to recommendation related to patient
     *
     * @param Recommandation $recommendation
     * @param int $idMenu
     *
     * @return bool|mixed|null
     * @throws \Exception
     */
    public function addMenuToRecommendation($recommendation, $idMenu)
    {
        $recommendation->menus()->attach($idMenu);
        return $recommendation->menus;
    }

    /**
     * Method for nutritionist to detach menu related to patient
     *
     * @param Recommandation $recommendation
     * @param $idMenu
     * @return mixed
     */
    public function destroyMenu($recommendation, $idMenu)
    {
        return $recommendation->menus()->detach($idMenu);
    }

    /**
     * Patient : Get the last recommendation
     * @param Patient $patient
     * @return mixed
     */
    public function getRecommendationByPatient($patient)
    {
        return $patient->recommendations()->latest("updated_at")->first();
    }

    /**
     * Patient : Get the list of menus linked to a recommendation
     * @param Patient $patient
     * @return mixed
     */
    public function getRecommendationMenusByPatient($patient)
    {
        $recommendation = $patient->recommendations()->latest("updated_at")->first();
        return $recommendation->menus;
    }
}
