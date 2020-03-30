<?php


namespace App\Repositories;

use App\Recommendation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
     * @param String $name
     * @param string $avoid
     *
     * @return false|Model
     */
    public function updateRecommendation($name, $avoid)
    {
        $this->recommendation->avoid = $avoid;
        $this->recommendation->name = $name;
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
     * Method  to get menus posted by  patient
     *
     * @return mixed
     */
    public function menusOfPatient()
    {
        $menus = $this->recommendation->menus;
        $menu = $menus->whereIn(
            'type_menu',
            array(
                'suppCollations2',
                'suppCollation1',
                'suppPetit-Déjeuner',
                'suppDéjeuner',
                'suppDiner'
            )
        );
        return $menu;
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
