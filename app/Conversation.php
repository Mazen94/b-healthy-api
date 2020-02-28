<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    /* conversation Attributes:
     *      int id
     *      int nutritionist_id
     *      int patient_id
     *
     */

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
