<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    /*  Visit Attributes:
         *      int id
         *      int id_patient
         *      string message
         */
    protected $table = 'notifications';

    /**
     * One To Many (Inverse)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patient()
    {
        return $this->belongsTo('App\Patient');
    }
}
