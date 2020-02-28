<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    /* Patient Attributes:
     *      int id
     *      string firstname
     *      string email
     *      string lastName
     *      string picture
     *      string numberPhone
     *      string gender
     *      string profession
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
        return $this->belongsTo('App\Models\Nutritionist');
    }

    /**
     * One To one
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function conversation()
    {
        return $this->hasOne('App\Models\Conversation');
    }

    /**
     * the has many relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function visits()
    {
        return $this->hasMany('App\Models\Visit');
    }

    /**
     * the has many relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activitephysiques()
    {
        return $this->hasMany('App\Models\Activitephysique');
    }

    /**
     * the has many relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notifications()
    {
        return $this->hasMany('App\Models\Notification');
    }

    /**
     * Many To Many RelationShip
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function recommandations()
    {
        return $this->belongsToMany('App\Models\Recommandation')
            ->using('App\Models\PatientRecommandation');
    }
}