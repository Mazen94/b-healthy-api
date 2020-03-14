<?php


namespace App\Repositories;

use App\Recommendation;
use Illuminate\Database\Eloquent\Model;

class RecommendationRepository
{
    protected $recommendation;

    public function __construct(Recommendation $recommendation)
    {
        $this->recommendation = $recommendation;
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
        $this->recommendation->avoid = $avoid;
        $this->recommendation->save();
        return $this->recommendation;
    }

    /**
     * Method for nutritionist to delete recommendation related to patient
     *
     *
     * @throws \Exception
     */
    public function deleteRecommendation()
    {
        $this->recommendation->delete();
    }

    /**
     * Method to add menu to recommendation related to patient
     *
     *
     * @param int $idMenu
     *
     * @return bool|mixed|null
     * @throws \Exception
     */
    public function addMenuToRecommendation($idMenu)
    {
        $this->recommendation->menus()->attach($idMenu);
        return $this->recommendation->menus;
    }

    /**
     * Method  to detach menu related to patient
     *
     *
     * @param $idMenu
     * @return mixed
     */
    public function destroyMenu($idMenu)
    {
        return $this->recommendation->menus()->detach($idMenu);
    }


}
