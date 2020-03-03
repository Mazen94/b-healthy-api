<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    /* Ingredient Attributes:
     *      int id
     *      int nutritionist_id
     *      int quantite
     *      int calorie
     */

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
        return $this->belongsToMany('App\Models\Storemenu')
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
