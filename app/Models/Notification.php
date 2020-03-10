<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Notification
 * @package App
 * @property int $id
 * @property string $message
 */
class Notification extends Model
{

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
