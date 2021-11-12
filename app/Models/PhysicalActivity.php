<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class PhysicalActivity
 * @package App
 * @property int $id
 * @property int $distance
 * @property int $duration
 * @property string $typical_activity
 * @property int $energy_burned
 */
class PhysicalActivity extends Model
{
    /**
     * @var string
     */
    protected $table = 'physicalActivity';
    /**
     * One To Many (Inverse)
     * @return BelongsTo
     */
    public function patient()
    {
        return $this->belongsTo('App\Patient');
    }
}
