<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Storemenu extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom','max_age','min_age','calorie','type_menu'
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
