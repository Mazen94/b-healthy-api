<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Visit
 * @package App
 * @property int $id
 * @property int $weight
 * @property string $note
 * @property  $scheduled_at
 * @property  $done_at
 *
 */
class Visit extends Model
{
    /*  Visit Attributes:
     *      int id
     *      int poids
     *      string note
     *      date scheduled_at
     *      date done_at
     *      int patient_id
     *
     */
    protected $fillable = [ 'poids','note','scheduled_at','done_at'];
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
