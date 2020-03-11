<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class RecommandationMenu
 * @package App
 * @property int menu_id
 * @property int recommandation_id
 */
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
