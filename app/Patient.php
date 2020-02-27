<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    /* Ingredient Attributes:
     *      int id
     *      string firstname
     *      string email
     *      string lastName
     *      string picture
     *      string numberPhone
     *      string gender
     *      string profession
     *
     */

    /**
     * @var string
     */
    protected $table = 'patients';

    /**
     * One To Many (Inverse)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function nutritionist()
    {
        return $this->belongsTo('App\Nutritionist');
    }

    /**
     * One To one
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function conversation()
    {
        return $this->hasOne('App\Conversation');
    }
    /**
     * the has many relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function visits()
    {
        return $this->hasMany('App\Visit');
    }
}
