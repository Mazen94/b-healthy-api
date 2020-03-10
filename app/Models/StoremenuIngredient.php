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
    protected $fillable = ['storemenu_id', 'ingredients_id'];
    /**
     * Class Pivot between StoreMenu et Ingredients
     */
    /**
     * @var string
     */
    protected $table = 'storemenus_ingredients';


}
