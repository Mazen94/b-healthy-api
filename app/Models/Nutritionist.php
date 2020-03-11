<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class Nutritionist
 * @package App
 * @property int $id
 * @property string $firstName
 * @property string $email
 * @property string $lastName
 * @property string $picture
 * @property string $password
 *
 */
class Nutritionist extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * @var string
     */
    protected $table = 'nutritionists';
    protected $hidden = ['password'];

    /**
     * the has many relationship
     * @return HasMany
     */
    public function patients()
    {
        return $this->hasMany('App\Patient');
    }

    /**
     * the has many relationship
     * @return HasMany
     */
    public function storemenus()
    {
        return $this->hasMany('App\Storemenu');
    }

    /**
     * the has many relationship
     * @return HasMany
     */
    public function ingredients()
    {
        return $this->hasMany('App\Ingredient');
    }

    /**
     * the has many relationship
     * @return HasMany
     */
    public function conversations()
    {
        return $this->hasMany('App\Conversation');
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
