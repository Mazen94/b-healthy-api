<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PatientRecommandation extends Pivot
{
    /**
     * Class Pivot between StoreMenu et Ingredients
     */
    /**
     * @var string
     */
    protected $table = 'patients_recommandations';

}
