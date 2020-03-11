<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class PatientRecommandation
 * @package App
 * @property int patient_id
 * @property int recommandation_id
 */
class PatientRecommandation extends Pivot
{
    /**
     * Class Pivot between Patient et Recommandation
     */
    /**
     * @var string
     */
    protected $table = 'patients_recommandations';

}
