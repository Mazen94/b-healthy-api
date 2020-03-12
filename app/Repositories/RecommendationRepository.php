<?php


namespace App\Repositories;

use App\Patient;
use App\Recommandation;
use Illuminate\Database\Eloquent\Model;

class RecommendationRepository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Method for nutritionist to create a new recommendation related to patient
     *
     *
     * @param string $avoid
     * @return false|Model
     */
    public function createRecommendation($avoid)
    {
        $recommendation = new Recommandation();
        $recommendation->avoid = $avoid;
        $recommendation->save();
        $this->model->recommendations()->attach($recommendation->id);
        return $recommendation;
    }

    /**
     * Method for nutritionist to update recommendation related to patient
     *
     *
     * @param string $avoid
     *
     * @return false|Model
     */
    public function updateRecommendation($avoid)
    {
        $this->model->avoid = $avoid;
        $this->model->save();
        return $this->model;
    }

    /**
     * Method for nutritionist to delete recommendation related to patient
     *
     *
     * @throws \Exception
     */
    public function deleteRecommendation()
    {
        $this->model->delete();
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
    public function addMenuToRecommendation($idMenu)
    {
        $this->model->menus()->attach($idMenu);
        return $this->model->menus;
    }

    /**
     * Method for nutritionist to detach menu related to patient
     *
     * @param Recommandation $recommendation
     * @param $idMenu
     * @return mixed
     */
    public function destroyMenu($idMenu)
    {
        return $this->model->menus()->detach($idMenu);
    }

    /**
     * Patient : Get the last recommendation
     * @param Patient $patient
     * @return mixed
     */
    public function getRecommendationByPatient()
    {
        return $this->model->recommendations()->latest("updated_at")->first();
    }

    /**
     * Patient : Get the list of menus linked to a recommendation
     * @param Patient $patient
     * @return mixed
     */
    public function getRecommendationMenusByPatient()
    {
        $recommendation = $this->model->recommendations()->latest("updated_at")->first();
        return $recommendation->menus;
    }
}
