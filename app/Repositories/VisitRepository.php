<?php


namespace App\Repositories;

use App\Visit;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Date;


class VisitRepository
{
    protected $visit;

    public function __construct(Visit $visit)
    {
        $this->visit = $visit;
    }

    /**
     * Method for nutritionist to update Visit related to patient
     *
     * @param int $weight
     * @param string $note
     * @param Date $scheduledAt
     * @param Date $doneAt
     *
     * @return bool|false|Collection|Model|HasMany|HasMany[]
     */
    public function updateVisit($weight, $note, $scheduledAt, $doneAt)
    {
        $this->visit->weight = $weight;
        $this->visit->scheduled_at = $scheduledAt;
        if (!empty($doneAt)) {
            $this->visit->done_at = $doneAt;
        }
        if (!empty($note)) {
            $this->visit->note = $note;
        }
        $this->visit->save();

        return $this->visit;
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
    public function deleteVisit()
    {
        return $this->visit->delete();
    }
}
