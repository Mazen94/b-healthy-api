<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Storemenu
 * @package App
 * @property int $id
 * @property string $name
 * @property int $max_age
 * @property int $min_age
 * @property int $calorie
 * @property string type_menu
 */
class Storemenu extends Model
{


    /**
     * @var string
     */

    protected $table = 'storemenus';


    /**
     * One To Many (Inverse)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function nutritionist()
    {
        return $this->belongsTo('App\Nutritionist');
    }

    /**
     * Many To Many RelationShip
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function ingredients()
    {
        return $this->belongsToMany(
            'App\Ingredient',
            'storemenus_ingredients',
            'storemenu_id',
            'ingredients_id'
        )->withPivot('amount')
            ->using('App\StoremenuIngredient');
    }

}
