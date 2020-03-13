<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Recommendation
 * @package App
 *
 * @property int $id
 * @property string $avoid
 */
class Recommendation extends Model
{
    /**
     * @var string
     */
    protected $table = 'recommendations';

    /**
     * Many To Many RelationShip
     * @return BelongsToMany
     */
    public function patients()
    {
        return $this->belongsToMany('App\Recommendation');
    }

    /**
     * Many To Many RelationShip between menu et recommendation
     * @return BelongsToMany
     */
    public function menus()
    {
        return $this->belongsToMany('App\Menu');
    }
}
