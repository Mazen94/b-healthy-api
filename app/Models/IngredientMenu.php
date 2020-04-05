<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class IngredientMenu
 * @package App
 * @property int $menu_id
 * @property int $ingredient_id
 * @property int $amount
 */
class IngredientMenu extends Pivot
{

}
