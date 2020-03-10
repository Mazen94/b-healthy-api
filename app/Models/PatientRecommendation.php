<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PatientRecommendation extends Pivot
{
    /**
     * Class Pivot between Patient et Recommandation
     */
    /**
     * @var string
     */
    protected $table = 'patients_recommandations';

}
