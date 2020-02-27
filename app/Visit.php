<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    /* Visit Attributes:
     *      int id
     *      int poids
     *      string note
     *      date scheduled_at
     *      date done_at
     *      int patient_id
     *
     */
    protected $table = 'visits';
    /**
     * One To Many (Inverse)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patient()
    {
        return $this->belongsTo('App\Patient');
    }
}
