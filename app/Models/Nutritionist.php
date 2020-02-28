<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nutritionist extends Model
{
    /* nutritionists Attributes:
     *      int id
     *      string firstname
     *      string email
     *      string lastName
     *      string picture
     */

    /**
     * @var string
     */
    protected $table = 'nutritionists';


    /**
     * the has many relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function patients()
    {
        return $this->hasMany('App\Patient');
    }

    /**
     * the has many relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function storemenus()
    {
        return $this->hasMany('App\Models\Storemenu');
    }
    /**
     * the has many relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ingredients()
    {
        return $this->hasMany('App\Models\\Ingredient');
    }

    /**
     * the has many relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function conversations()
    {
        return $this->hasMany('App\Models\Conversation');
    }
}
