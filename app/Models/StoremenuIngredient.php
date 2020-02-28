<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class StoremenuIngredient extends Pivot
{
    /**
     * Class Pivot between StoreMenu et Ingredients
     */
    /**
     * @var string
     */
    protected $table = 'storemenus_ingredients';
}
