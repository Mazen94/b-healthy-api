<?php

namespace App;


use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Class Patient
 * @package App
 * @property integer $id
 * @property string $email
 * @property string $firstName
 * @property string $lastName
 * @property string $picture
 * @property string $gender
 * @property string $profession
 * @property string $numberPhone
 */
class Patient extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * @var string
     */
    protected $table = 'patients';
    protected $hidden = ['password'];

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
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
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

    /**
     * the has many relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function physicalActivity()
    {
        return $this->hasMany('App\Activitephysique');
    }

    /**
     * the has many relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notifications()
    {
        return $this->hasMany('App\Notification');
    }

    /**
     * Many To Many RelationShip
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function recommandations()
    {
        return $this->belongsToMany(
            'App\Recommandation',
            'patients_recommandations',
            'patient_id',
            'recommandation_id'
        )->using('App\PatientRecommandation');
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
