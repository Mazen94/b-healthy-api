<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Ingredient
 * @package App
 * @property integer $id
 * @property string $name
 * @property integer $amount
 * @property integer $calorie
 */
class Ingredient extends Model
{

    /**
     * @var string
     */
    protected $table = 'ingredients';


    /**
     * One To Many (Inverse)
     * @return BelongsTo
     */
    public function nutritionist()
    {
        return $this->belongsTo('App\Models\Nutritionist');
    }

    /**
     * ManyToMany
     * @return BelongsToMany
     */
    public function mealStore()
    {
        return $this->belongsToMany('App\MealStore')->withPivot('amount');
    }

    /**
     * Many To Many RelationShip between menu et ingredients
     * @return BelongsToMany
     */
    public function menus()
    {
        return $this->belongsToMany('App\Menu')
            ->using('App\MenuIngredients');
    }
}
