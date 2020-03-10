<?php


namespace App\Repositories;

use App\Patient;
use App\Visit;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Date;


class VisitRepository
{

    /**
     * Method for nutritionist to update Visit related to patient
     *
     * @param Visit $visit
     * @param int $weight
     * @param string $note
     * @param Date $scheduled_at
     * @param Date $done_at
     *
     * @return bool|false|Collection|Model|HasMany|HasMany[]
     */
    public static function updateVisit($visit, $weight, $note, $scheduled_at, $done_at)
    {
        $visit->weight = $weight;
        $visit->scheduled_at = $scheduled_at;
        if (!empty($done_at)) {
            $visit->done_at = $done_at;
        }
        if (!empty($note)) {
            $visit->note = $note;
        }
        $visit->save();

        return $visit;
    }

    /**
     * Method for nutritionist to create a new visit related to patient
     *
     * @param Patient $patient
     * @param int $weight
     * @param string $note
     * @param Date $scheduled_at
     * @param Date $done_at
     *
     * @return false|Model
     */
    public static function createVisit($patient, $weight, $note, $scheduled_at, $done_at)
    {
        $visit = new Visit();
        $visit->weight = $weight;
        $visit->scheduled_at = $scheduled_at;
        if (!empty($done_at)) {
            $visit->done_at = $done_at;
        }
        if (!empty($note)) {
            $visit->note = $note;
        }
        return $patient->visits()->save($visit);
    }

    /**
     * Method to delete visit related to patient
     *
     * @param Visit $visit
     *
     * @return bool|mixed|null
     *
     * @throws \Exception
     */
    public static function deleteVisit($visit)
    {
        return $visit->delete();
    }
}
