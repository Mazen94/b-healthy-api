<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class MenuIngredients extends Pivot
{
    /**
     * Class Pivot between Menu et Ingredients
     */
    /**
     * @var string
     */
    protected $table = 'menus_ingredients';
}
