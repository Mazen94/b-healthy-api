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
     * @param $belly
     * @param $chest
     * @param $legs
     * @param $neck
     * @param $tall
     * @param $scheduledAt
     * @param $meetingHour
     * @return Visit
     */
    public function updateVisit($weight, $note, $belly, $chest, $legs, $neck, $tall, $scheduledAt, $meetingHour)
    {
        $this->visit->weight = $weight;
        $this->visit->meetingHour = $meetingHour;
        $this->visit->scheduledAt = $scheduledAt;
        $this->visit->belly = $belly;
        $this->visit->chest = $chest;
        $this->visit->legs = $legs;
        $this->visit->neck = $neck;
        $this->visit->tall = $tall;
        $this->visit->note = $note;
        $this->visit->save();

        return $this->visit;
    }

    /**
     * hour of meeting  by date
     * @param $date
     * @return mixed
     */
    public static function showMeetingByDate($date)
    {
        return Visit::select('meetingHour')->where('scheduledAt', $date)->get();
    }

    /**
     * check visit of patient by current date
     * @param $id
     * @return mixed
     */
    public static function checkVisit($id)
    {
        $date = date('Y-m-d');
        return Visit::whereDate('created_at', $date)->where('patient_id', $id)->get();
    }

    /**
     * hour of meeting  by date
     * @param $id
     * @return mixed
     */
    public static function checkMeetingDayById($id)
    {
        $date = date('Y-m-d');
        return Visit::select('meetingHour', 'id')->where('scheduledAt', $date)->where('patient_id', $id)->where(
            'meetingStatus',
            0
        )->get();
    }

    /**
     * update the value of meeting to 1
     * @param $visit
     * @return mixed
     */
    public static function deleteMeeting($visit)
    {
        $visit->meetingStatus = 1;
        $visit->save();
    }
}
