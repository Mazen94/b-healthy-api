<?php


namespace App\Repositories;


use App\Menu;
use Illuminate\Database\Eloquent\Model;
use Config;

class MenuRepository
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
     * Method to create a new  menu
     *
     * @param $request
     *
     * @return false|\Illuminate\Database\Eloquent\Model
     */
    public function createMenu($request, $id_recommendation)
    {
        //TODO change $request
        $recommendation = $this->model->recommandations()->findOrFail($id_recommendation);
        $menu = new Menu();
        $menu->name = $request->name;
        $menu->type_menu = $request->type_menu;
        $menu->posted_by = Config::get('constants.POSTED_BY_PATIENT');
        $menu->save();
        $recommendation->menus()->attach($menu->id);
        return $recommendation->menus()->findOrFail($menu->id);
    }
}
