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
    public static function createRecommendation($patient, $avoid)
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
    public static function updateRecommendation($recommendation, $avoid)
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
    public static function deleteRecommendation($recommendation)
    {
        $recommendation->delete();
    }

    /**
     * Method for nutritionist to add menu to recommendation related to patient
     *
     * @param Recommandation $recommendation
     * @param int $id_menu
     *
     * @return bool|mixed|null
     * @throws \Exception
     */
    public static function addMenuToRecommendation($recommendation, $id_menu)
    {
        $recommendation->menus()->attach($id_menu);
        return $recommendation->menus;
    }

    /**
     *   Method for nutritionist to detach menu related to patient
     *
     * @param Recommandation $recommendation
     * @param $id_menu
     * @return mixed
     */
    public static function destroyMenu($recommendation, $id_menu)
    {
        return $recommendation->menus()->detach($id_menu);
    }

    /**
     *  Patient : Get the last recommendation
     * @return mixed
     */
    public function getRecommendationByPatient()
    {
        return $this->model->recommandations()->latest("updated_at")->first();
    }

    /**
     *  Patient : Get the list of menus linked to a recommendation
     * @return mixed
     */
    public function getRecommendationMenusByPatient()
    {
        $recommendation = $this->model->recommandations()->latest("updated_at")->first();
        return $recommendation->menus;
    }
}
