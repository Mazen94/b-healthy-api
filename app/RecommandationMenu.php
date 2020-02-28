<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class RecommandationMenu extends Pivot
{
    /**
     * Class Pivot between Recommandation et Menu
     */
    /**
     * @var string
     */
    protected $table = 'menus_recommandations';
}
