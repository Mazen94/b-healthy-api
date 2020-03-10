<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class MenuIngredients
 * @package App
 * @property int $menu_id
 * @property int $ingredients_id
 * @property int $amount
 *
 */
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
