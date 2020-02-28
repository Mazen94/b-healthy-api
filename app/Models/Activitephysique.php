<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activitephysique extends Model
{
    /* Activitephysique Attributes:
     *      int id
     *      int distance
     *      int patient_id
     *      time duration
     *      int energy_burned
     *      string activite_type
     */

    /**
     * @var string
     */
    protected $table = 'activitephysiques';

    /**
     * One To Many (Inverse)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patient()
    {
        return $this->belongsTo('App\Models\Patient');
    }


}
