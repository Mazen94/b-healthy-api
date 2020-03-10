<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function nutritionist()
    {
        return $this->belongsTo('App\Models\Nutritionist');
    }

    /**
     * ManyToMany
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function storemenus()
    {
        return $this->belongsToMany(
            'App\Storemenu',
            'storemenus_ingredients',
            'ingredients_id',
            'storemenu_id'
        )->withPivot('amount')
            ->using('App\StoremenuIngredient');
    }

    /**
     * Many To Many RelationShip between menu et ingredients
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function menus()
    {
        return $this->belongsToMany('App\Menu')
            ->using('App\MenuIngredients');
    }
}
