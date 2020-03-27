<?php


namespace App\Repositories;


use App\Notification;
use App\Patient;
use App\PhysicalActivity;
use App\Recommendation;
use App\Visit;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;


class PatientRepository
{
    protected $patient;

    public function __construct(Patient $patient)
    {
        $this->patient = $patient;
    }


    /**
     * Method to delete patient related to nutritionist
     *
     * @return bool|mixed|null
     * @throws \Exception
     */
    public function deletePatient()
    {
        return $this->patient->delete();
    }

    /**
     * Method for patient to update patient connected
     *
     * @param string $email
     * @param string $firstName
     * @param string $lastName
     * @param string $gender
     * @param string $numberPhone
     * @param string $profession
     * @return bool|mixed|null
     */
    public function updatePatient(
        $email,
        $firstName,
        $lastName,
        $gender,
        $numberPhone,
        $profession
    ) {
        $this->patient->email = $email;
        $this->patient->firstName = $firstName;
        $this->patient->lastName = $lastName;
        //$this->patient->password = bcrypt($password);
        $this->patient->gender = $gender;
        $this->patient->profession = $numberPhone;
        $this->patient->numberPhone = $profession;
        $this->patient->save();
        return $this->patient;
    }


    /**
     * Method for nutritionist to create a new recommendation related to patient
     *
     *
     * @param string $avoid
     * @return false|Model
     */
    public function createRecommendation($avoid)
    {
        $recommendation = new Recommendation();
        $recommendation->avoid = $avoid;
        $recommendation->save();
        $this->patient->recommendations()->attach($recommendation->id);
        return $recommendation;
    }

    /**
     * Patient : Get the last recommendation
     *
     * @return mixed
     */
    public function getRecommendationByPatient()
    {
        return $this->patient->recommendations()->latest("updated_at")->first();
    }

    /**
     * Patient : Get the list of menus linked to a recommendation
     *
     * @return mixed
     */
    public function getRecommendationMenusByPatient()
    {
        $recommendation = $this->patient->recommendations()->latest("updated_at")->first();
        return $recommendation->menus;
    }

    /**
     * show Visits related to patient
     * @param int $page
     * @param int $perPage
     * @param string $orderBy
     * @param string $orderDirection
     * @return LengthAwarePaginator
     */
    public function paginateVisits($page, $perPage, $orderBy, $orderDirection)
    {
        $VisitsGroups = $this->patient->visits();
        if (isset($orderBy) && isset($orderDirection)) {
            $VisitsGroups->orderBy($orderBy, $orderDirection);
        }
        return $VisitsGroups->paginate($perPage, ['*'], 'page', $page);
    }

    /**
     * Method for nutritionist to create a new visit related to patient
     *
     * @param int $weight
     * @param string $note
     * @param int $belly
     * @param int $chest
     * @param int $legs
     * @param int $neck
     * @param int $tall
     * @param Date $scheduledAt
     * @param Date $doneAt
     *
     * @return false|Model
     */
    public function createVisit($weight, $note,$belly, $chest,$legs, $neck,$tall, $scheduledAt, $doneAt)
    {
        $visit = new Visit();
        $visit->weight = $weight;
        $visit->scheduled_at = $scheduledAt;
        if (!empty($doneAt)) {
            $visit->done_at = $doneAt;
        }
        if (!empty($belly)) {
            $visit->belly = $belly;
        }
        if (!empty($chest)) {
            $visit->chest = $chest;
        }
        if (!empty($legs)) {
            $visit->legs = $legs;
        }
        if (!empty($neck)) {
            $visit->neck = $neck;
        }
        if (!empty($tall)) {
            $visit->tall = $tall;
        }
        if (!empty($note)) {
            $visit->note = $note;
        }
        return $this->patient->visits()->save($visit);
    }

    /**
     * Method to post notification
     *
     * @param String $message
     *
     * @return mixed
     */
    public function postNotification($message)
    {
        $notification = new Notification();
        $notification->message = $message;
        $this->patient->notifications()->save($notification);
        return $notification;
    }

    /**
     * Method to create a new  Activity
     *
     *
     * @param int $distance
     * @param $activityType
     * @param int $energyBurned
     * @param int $duration
     *
     * @return false|Model
     */
    public function createActivity($distance, $activityType, $energyBurned, $duration)
    {
        $activity = new PhysicalActivity();
        $activity->distance = $distance;
        $activity->typical_activity = $activityType;
        $activity->energy_burned = $energyBurned;
        $activity->duration = $duration;
        $this->patient->physicalActivity()->save($activity);
        return $activity;
    }
}
