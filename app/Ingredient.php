<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    /**
    * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $fillable = [
        'nom','calorie_g','calorie_l'
    ];

    /**
     * One To Many (Inverse)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function nutritionist()
    {
        return $this->belongsTo('App\Nutritionist');
    }
}
