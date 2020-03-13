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
