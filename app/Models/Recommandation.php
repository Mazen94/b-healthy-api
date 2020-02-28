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
        return $this->belongsToMany('App\Models\Patient')
            ->using('App\PatientRecommandation');
    }

    /**
     * Many To Many RelationShip between menu et recommandation
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function menus()
    {
        return $this->belongsToMany('App\Menu')
            ->using('App\Models\RecommandationMenu');
    }
}
