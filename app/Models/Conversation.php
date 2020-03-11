<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Conversation
 * @package App
 * @property int $id
 * @property int $nutritionist_id
 * @property int $patient_id
 */
class Conversation extends Model
{
    /**
     * @var string
     */
    protected $table = 'conversations';

    /**
     * One To Many (Inverse)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function nutritionist()
    {
        return $this->belongsTo('App\Nutritionist');
    }

    /**
     * One To one (Inverse)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patient()
    {
        return $this->belongsTo('App\Patient');
    }

    /**
     * the has many relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function message()
    {
        return $this->hasMany('App\Message');
    }
}
