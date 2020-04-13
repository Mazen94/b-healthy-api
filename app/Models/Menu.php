<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Menu
 * @package App
 * @property int $id
 * @property string $name
 * @property int $calorie
 * @property string $type_menu
 */
class Menu extends Model
{
    const TYPE_MENU = [
        'BREAKFAST' => 0,
        'FIRST_SNAKE' => 1,
        'LUNCH' => 2,
        'SECOND_SNAKE' => 3,
        'DINNER' => 4,
        'SUPP_BREAKFAST' => 5,
        'SUPP_FIRST_SNAKE' => 6,
        'SUPP_LUNCH' => 7,
        'SUPP_SECOND_SNAKE' => 8,
        'SUPP_DINNER' => 9,
    ];
    /**
     * @var string
     */
    protected $table = 'menus';

    /**
     * Many To Many RelationShip between menu et recommendation
     * @return BelongsToMany
     */
    public function recommendations()
    {
        return $this->belongsToMany('App\Recommendation');
    }

    /**
     * Many To Many RelationShip between menu et ingredients
     * @return BelongsToMany
     */
    public function ingredients()
    {
        return $this->belongsToMany('App\Ingredient')->withPivot('amount');
    }

}
