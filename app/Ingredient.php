<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    /* Ingredient Attributes:
     *      int id
     *      int nutritionist_id
     *      int quantite
     *      int calorie
     */

    /**
     * @var string
     */
    protected $table = 'ingredients';

    /**
     * One To Many (Inverse)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function nutritionist()
    {
        return $this->belongsTo('App\Nutritionist');
    }
}
