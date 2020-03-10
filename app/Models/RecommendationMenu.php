<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class RecommendationMenu extends Pivot
{
    /**
     * Class Pivot between Recommandation et Menu
     */
    /**
     * @var string
     */
    protected $table = 'menus_recommandations';
}
