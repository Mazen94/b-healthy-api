<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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


    protected $fillable = ['poids', 'note', 'scheduled_at', 'done_at'];
    protected $table = 'visits';

    /**
     * One To Many (Inverse)
     * @return BelongsTo
     */
    public function patient()
    {
        return $this->belongsTo('App\Patient');
    }
}
