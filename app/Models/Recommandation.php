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
        return $this->belongsToMany(
            'App\Recommandation',
            'patients_recommandations',
            'recommandation_id',
            'patient_id'
        )->using('App\PatientRecommandation');
    }

    /**
     * Many To Many RelationShip between menu et recommandation
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function menus()
    {
        return $this->belongsToMany(
            'App\Menu',
            'menus_recommandations',
            'recommandation_id',
            'menu_id'
        )->using('App\RecommandationMenu');
    }
}
