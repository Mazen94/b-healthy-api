<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Menu
 * @package App
 * @property int $id
 * @property string $name
 * @property int $calorie
 * @property string $type_menu
 */
class Menu extends Model
{

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
        return $this->belongsToMany(
            'App\Recommandation',
            'menus_recommandations',
            'menu_id',
            'recommandation_id'
        )->using('App\RecommandationMenu');
    }

    /**
     * Many To Many RelationShip between menu et ingredients
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function ingredients()
    {
        return $this->belongsToMany(
            'App\Ingredient',
            'menus_ingredients',
            'menu_id',
            'ingredients_id'
        )->withPivot('amount')
            ->using('App\MenuIngredients');
    }

}
