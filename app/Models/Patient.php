<?php

namespace App;


use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Class Patient
 * @package App
 * @property integer $id
 * @property string $email
 * @property string $password
 * @property string $firstName
 * @property string $lastName
 * @property string $picture
 * @property string $gender
 * @property string $profession
 * @property string $numberPhone
 * @property int $age
 */
class Patient extends Authenticatable implements JWTSubject
{

    use Notifiable;
    const TYPE_MENU = [
        'MALE' => 0,
        'FEMALE' => 1
    ];

    /**
     * @var string
     */
    protected $table = 'patients';
    protected $hidden = ['password'];

    /**
     * One To Many (Inverse)
     * @return BelongsTo
     */
    public function nutritionist()
    {
        return $this->belongsTo('App\Nutritionist');
    }

    /**
     * One To one
     * @return HasOne
     */
    public function conversation()
    {
        return $this->hasOne('App\Conversation');
    }

    /**
     * the has many relationship
     * @return HasMany
     */
    public function visits()
    {
        return $this->hasMany('App\Visit');
    }

    /**
     * the has many relationship
     * @return HasMany
     */
    public function physicalActivity()
    {
        return $this->hasMany('App\PhysicalActivity');
    }

    /**
     * the has many relationship
     * @return HasMany
     */
    public function notifications()
    {
        return $this->hasMany('App\Notification');
    }

    /**
     * Many To Many RelationShip
     * @return BelongsToMany
     */
    public function recommendations()
    {
        return $this->belongsToMany('App\Recommendation');
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
