<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Storemenu extends Model
{
    /* Storemenu Attributes:
     *      int id
     *      string nom
     *      int max_age
     *      int min_age
     *      string type_menu
     *      int nutritionnist
     *
     */

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
