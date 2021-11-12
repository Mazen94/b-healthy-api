<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class IngredientMealStore
 * @package App
 * @property  int $meal_store_id
 * @property int $ingredient_id
 * @property int $amount
 */
class IngredientMealStore extends Model
{
    protected $table = 'ingredient_meal_store';
}
