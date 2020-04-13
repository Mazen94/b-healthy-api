<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class MealStore
 * @package App
 *
 * @property int $id
 * @property string $name
 * @property int $max_age
 * @property int $min_age
 * @property int $calorie
 * @property string type_menu
 */
class MealStore extends Model
{
    const  TYPE_MENU = [
        'BREAKFAST' => 0,
        'FIRST_SNAKE' => 1,
        'LUNCH' => 2,
        'SECOND_SNAKE' => 3,
        'DINNER' => 4,
    ];

    protected $table = 'mealStore';


    /**
     * One To Many (Inverse)
     * @return BelongsTo
     */
    public function nutritionist()
    {
        return $this->belongsTo('App\Nutritionist');
    }

    /**
     * Many To Many RelationShip
     * @return BelongsToMany
     */
    public function ingredients()
    {
        return $this->belongsToMany('App\Ingredient')->withPivot('amount');
    }
}
