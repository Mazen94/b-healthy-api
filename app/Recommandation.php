<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recommandation extends Model
{
    /* Storemenu Attributes:
     *      int id
     *      string aeviter
     */

    /**
     * @var string
     */
    protected $table = 'recommandations';

    /**
     * Many To Many RelationShip
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function patients()
    {
        return $this->belongsToMany('App\Patient')
            ->using('App\PatientRecommandation');
    }
}
