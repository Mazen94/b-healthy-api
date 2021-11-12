<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Visit
 * @package App
 * @property int $id
 * @property int $weight
 * @property int $belly
 * @property int $chest
 * @property int $legs
 * @property int $neck
 * @property int $tall
 * @property string $note
 * @property  $scheduledAt
 * @property  $meetingHour
 *
 */
class Visit extends Model
{

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
