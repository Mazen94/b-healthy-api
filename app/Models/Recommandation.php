<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Recommendation
 * @package App
 * @property int $id
 * @property string $avoid
 */
class Recommandation extends Model
{

    /**
     * @var string
     */
    protected $table = 'recommandations';

    /**
     * Many To Many RelationShip
     * @return BelongsToMany
     */
    public function patients()
    {
        return $this->belongsToMany(
            'App\Recommandation',
            'patients_recommandations',
            'recommandation_id',
            'patient_id'
        )->using('App\PatientRecommendation');
    }

    /**
     * Many To Many RelationShip between menu et recommandetion
     * @return BelongsToMany
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
