<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PhysicalAcitivity
 * @package App
 * @property int $id
 * @property int $distance
 * @property int $duration
 * @property string $typical_activity
 * @property int $energy_burned
 */
class PhysicalAcitivity extends Model
{
    /**
     * @var string
     */
    protected $table = 'physicalActivity';
}
