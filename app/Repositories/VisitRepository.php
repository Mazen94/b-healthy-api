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
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
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
        $this->model->weight = $weight;
        $this->model->scheduled_at = $scheduledAt;
        if (!empty($doneAt)) {
            $this->model->done_at = $doneAt;
        }
        if (!empty($note)) {
            $this->model->note = $note;
        }
        $this->model->save();

        return $this->model;
    }

    /**
     * Method for nutritionist to create a new visit related to patient
     *
     * @param int $weight
     * @param string $note
     * @param Date $scheduledAt
     * @param Date $doneAt
     *
     * @return false|Model
     */
    public function createVisit($weight, $note, $scheduledAt, $doneAt)
    {
        $visit = new Visit();
        $visit->weight = $weight;
        $visit->scheduled_at = $scheduledAt;
        if (!empty($doneAt)) {
            $visit->done_at = $doneAt;
        }
        if (!empty($note)) {
            $visit->note = $note;
        }
        return $this->model->visits()->save($visit);
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
        return $this->model->delete();
    }
}
