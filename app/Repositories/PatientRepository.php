<?php


namespace App\Repositories;


use App\Ingredient;
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
        $this->deleteAllRecommendation($this->patient->recommendations);
        $this->patient->visits()->delete();
        return $this->patient->delete();
    }

    /**
     * Method to delete all the recommendation
     * @param $recommendations
     * @throws \Exception
     *
     */
    public function deleteAllRecommendation($recommendations)
    {
        foreach ($recommendations as $recommendation) {
            $recommendationRepository = new RecommendationRepository($recommendation);
            $recommendationRepository->deleteRecommendation();
        }
    }

    /**
     * Method for patient to update patient connected
     *
     * @param string $email
     * @param string $firstName
     * @param string $lastName
     * @param int $gender
     * @param string $numberPhone
     * @param string $profession
     * @param int $age
     * @param string $password
     * @return bool|mixed|null
     */
    public function updatePatient(
        $email,
        $firstName,
        $lastName,
        $gender,
        $numberPhone,
        $profession,
        $age,
        $password
    ) {
        $this->patient->email = $email;
        $this->patient->firstName = $firstName;
        $this->patient->lastName = $lastName;
        $this->patient->age = $age;
        $this->patient->gender = $gender;
        $this->patient->profession = $numberPhone;
        $this->patient->numberPhone = $profession;
        if (isset($password)) {
            $this->patient->password = bcrypt($password);
        }
        $this->patient->save();
        return $this->patient;
    }


    /**
     * Method for nutritionist to create a new recommendation related to patient
     *
     *
     * @param String $name
     * @param string $avoid
     * @return false|Model
     */
    public function createRecommendation($name, $avoid)
    {
        $recommendation = new Recommendation();
        $recommendation->avoid = $avoid;
        $recommendation->name = $name;
        $recommendation->save();
        $this->patient->recommendations()->attach($recommendation->id);
        return $recommendation;
    }

    /**
     * Patient : Get the last recommendation
     *
     * @return mixed
     */
    public function getLastRecommendation()
    {
        $recommendation = $this->patient->recommendations()->latest("updated_at")->first();
        if (!empty($recommendation)) {
            //add the menus created by nutritionist and the number of calories
            $recommendation["menus"] = $recommendation->menus()->whereIn('type_menu', array(0, 1, 2, 3, 4))->get();
            $recommendation['calories'] = $recommendation->menus()->whereIn('type_menu', array(0, 1, 2, 3, 4))->sum(
                'calorie'
            );
        }
        return $recommendation;
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
     * @param $date
     * @param $hour
     * @return false|Model
     */
    public function createVisit(
        $weight,
        $note,
        $belly,
        $chest,
        $legs,
        $neck,
        $tall,
        $date,
        $hour
    ) {
        $visit = new Visit();

        if (!empty($weight)) {
            $visit->weight = $weight;
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
        if (!empty($date)) {
            $visit->scheduledAt = $date;
        }
        if (!empty($hour)) {
            $visit->meetingHour = $hour;
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
     * @return PhysicalActivity
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

    /**
     * Get The list of ingredient
     * @param int $page
     * @param int $perPage
     * @param $orderBy
     * @param string $orderDirection
     * @param string $search
     * @return mixed
     */
    public function paginateIngredient($page, $perPage, $orderBy, $orderDirection, $search)
    {
        $nutritionistId = $this->patient->nutritionist_id;
        $ingredientsGroup = Ingredient::where('nutritionist_id', $nutritionistId);
        if (isset($search)) {
            $ingredientsGroup->where('name', 'like', '%' . $search . '%');
        }
        if (isset($orderBy) && isset($orderDirection)) {
            $ingredientsGroup->orderBy($orderBy, $orderDirection);
        }

        return $ingredientsGroup->paginate($perPage, ['*'], 'page', $page);
    }

    /**
     * Function to change the password
     * @param $password
     * @param $newPassword
     * @return bool
     */
    public function changePassword($password, $newPassword)
    {
        $this->patient->password = bcrypt($newPassword);
        $this->patient->save();
        return true;
    }

    /**
     * get the first weight for each month
     * @return mixed
     */
    public function weightAndMonth()
    {
        $weights = $this->patient->visits()->whereYear('created_at', date('Y'))->get(['created_at', 'weight']);
        foreach ($weights as $weight) {
            $weight['month'] = $weight->created_at->format('m');
        }
        return $weights->unique('month');
    }

    /**
     * get the first leg for each month
     * @return mixed
     */
    public function legsAndMonth()
    {
        $legs = $this->patient->visits()->whereYear('created_at', date('Y'))->get(['created_at', 'legs']);
        foreach ($legs as $leg) {
            $leg['month'] = $leg->created_at->format('m');
        }
        return $legs->unique('month');
    }

    /**
     * get the first leg for each month
     * @return mixed
     */
    public function bellyAndMonth()
    {
        $bellys = $this->patient->visits()->whereYear('created_at', date('Y'))->get(['created_at', 'belly']);
        foreach ($bellys as $belly) {
            $belly['month'] = $belly->created_at->format('m');
        }
        return $bellys->unique('month');
    }

    /**
     * get the first leg for each month
     * @return mixed
     */
    public function chestAndMonth()
    {
        $chests = $this->patient->visits()->whereYear('created_at', date('Y'))->get(['created_at', 'chest']);
        foreach ($chests as $chest) {
            $chest['month'] = $chest->created_at->format('m');
        }
        return $chests->unique('month');
    }
}
