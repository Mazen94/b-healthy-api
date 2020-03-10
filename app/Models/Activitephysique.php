<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Activitephysique
 * @package App
 * @property int $id
 * @property int $distance
 * @property int $duration
 * @property string $activite_type
 * @property int $energy_burned
 */
class Activitephysique extends Model
{

    /**
     * @var string
     */
    protected $table = 'physicalactivitys';

    /**
     * One To Many (Inverse)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patient()
    {
        return $this->belongsTo('App\Patient');
    }


}
