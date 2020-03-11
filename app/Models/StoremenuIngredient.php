<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class StoremenuIngredient
 * @package App
 * @property $storemenu_id
 * @property $ingredients_id
 * @property $amount
 */
class StoremenuIngredient extends Pivot
{
    /**
     * Class Pivot between StoreMenu et Ingredients
     */

    protected $fillable = ['storemenu_id', 'ingredients_id'];

    /**
     * @var string
     */
    protected $table = 'storemenus_ingredients';


}
