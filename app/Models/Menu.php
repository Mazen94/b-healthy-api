<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    /* menu Attributes:
    *      int id
    *      string nom
    *      int max_age
    *      int min_age
    *      string type_menu
    *      int nutritionnist
     *      int petit_dej_supp
     *      int dej_supp
     *      int dinner_supp
    */
    /**
     * @var string
     */
    protected $table = 'menus';

    /**
     * Many To Many RelationShip between menu et recommandation
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function recommandations()
    {
        return $this->belongsToMany('App\Recommandation')
            ->using('App\Models\RecommandationMenu');
    }

    /**
     * Many To Many RelationShip between menu et ingredients
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function ingredients()
    {
        return $this->belongsToMany('App\Ingredient')
            ->using('App\Models\MenuIngredients');
    }
}
