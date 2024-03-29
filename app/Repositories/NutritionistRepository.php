<?php


namespace App\Repositories;


use App\Ingredient;
use App\MealStore;
use App\Nutritionist;
use App\Patient;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Config;

class NutritionistRepository
{
    protected $nutritionist;

    public function __construct(Nutritionist $nutritionist)
    {
        $this->nutritionist = $nutritionist;
    }

    /**
     * @param $email
     * @param $firstName
     * @param $lastName
     * @param $password
     * @param $photo
     * @return Nutritionist
     */
    public static function register($email, $firstName, $lastName, $password,$photo)
    {
        $nutritionist = new Nutritionist();
        $nutritionist->email = $email;
        $nutritionist->firstName = $firstName;
        $nutritionist->lastName = $lastName;
        $nutritionist->password = bcrypt($password);
        $nutritionist->photo=$photo;
        $nutritionist->save();
        return $nutritionist;
    }

    /**
     * update nutritionist  from database
     *
     * @param $email
     * @param $firstName
     * @param $lastName
     * @param $password
     * @param $picture
     * @return mixed
     */
    public function updateNutritionist($email, $firstName, $lastName, $password)
    {
        $this->nutritionist->email = $email;
        $this->nutritionist->firstName = $firstName;
        $this->nutritionist->lastName = $lastName;
        if(isset($password)){
            $this->nutritionist->password = bcrypt($password);
        }
        $this->nutritionist->save();
        return $this->nutritionist;
    }

    /**
     * delete nutritionist  from database
     *
     * @throws \Exception
     */
    public function deleteNutritionist()
    {
        return $this->nutritionist->delete();
    }

    /**
     * show ingredients related to nutritionist
     * @param int $page
     * @param int $perPage
     * @param string $orderBy
     * @param string $orderDirection
     * @return LengthAwarePaginator
     */
    public function paginateIngredients($page, $perPage, $orderBy, $orderDirection)
    {
        $ingredientGroups = $this->nutritionist->ingredients();
        if (isset($orderBy) && isset($orderDirection)) {
            $ingredientGroups->orderBy($orderBy, $orderDirection);
        }
        return $ingredientGroups->paginate($perPage, ['*'], 'page', $page);
    }

    /**
     * Method to create a new Ingredient related to nutritionist
     *
     * @param $name
     * @param $amount
     * @param $calorie
     * @return false|Model
     */
    public function createIngredient($name, $amount, $calorie)
    {
        $ingredient = new Ingredient();
        $ingredient->name = $name;
        $ingredient->amount = $amount;
        $ingredient->calorie = $calorie;
        return $this->nutritionist->ingredients()->save($ingredient);
    }

    /**
     * show MealStore related to nutritionist
     * @param int $page
     * @param int $perPage
     * @param string $orderBy
     * @param string $orderDirection
     * @return LengthAwarePaginator
     */
    public function paginateMealStore($page, $perPage, $orderBy, $orderDirection)
    {
        $mealStoreGroups = $this->nutritionist->mealStore();
        if (isset($orderBy) && isset($orderDirection)) {
            $mealStoreGroups->orderBy($orderBy, $orderDirection);
        }
        return $mealStoreGroups->paginate($perPage, ['*'], 'page', $page);
    }

    /**
     * method to get only one StoreMenu with the ingredients related to nutritionist
     * @param int $age
     * @return Collection
     */
    public function getMealStoreWithIngredientsByAge($age)
    {
        return $this->nutritionist->mealStore()
            ->where('min_age', '<=', $age)
            ->where('max_age', '>=', $age)
            ->get();
    }

    /**
     * Method to create a new store menu related to nutritionist
     *
     * @param string $name
     * @param int $maxAge
     * @param int $minAge
     * @param int $calorie
     * @param string $typeMenu
     *
     * @return false|Model
     */
    public function createMealStore($name, $maxAge, $calorie, $minAge, $typeMenu)
    {
        $menu = new MealStore();
        $menu->name = $name;
        $menu->max_age = $maxAge;
        $menu->min_age = $minAge;
        $menu->type_menu = $typeMenu;
        $menu->calorie = $calorie;

        return $this->nutritionist->mealStore()->save($menu);
    }


    /**
     * show Patients related to nutritionist
     * @param int $page
     * @param int $perPage
     * @param string $orderBy
     * @param string $orderDirection
     * @param string $search
     * @return LengthAwarePaginator
     */
    public function paginatePatient($page, $perPage, $orderBy, $orderDirection, $search)
    {
        $mealStoreGroups = $this->nutritionist->patients();
        if (isset($search)) {
            $data = explode(' ', $search, 2);
            if (isset($data[1])) {
                $mealStoreGroups->where('firstName', 'like', '%' . $data[0] . '%')
                    ->where('lastName', 'like', '%' . $data[1] . '%');
            } else {
                $mealStoreGroups->where('firstName', 'like', '%' . $data[0] . '%');
            }
        }
        if (isset($orderBy) && isset($orderDirection)) {
            $mealStoreGroups->orderBy($orderBy, $orderDirection);
        }

        return $mealStoreGroups->paginate($perPage, ['*'], 'page', $page);
    }

    /**
     * Method to create a new patient related to patient
     *
     *
     * @param string $email
     * @param string $firstName
     * @param string $lastName
     * @param string $password
     * @param string $gender
     * @param string $numberPhone
     * @param string $profession
     * @return false|Model
     */
    public function createPatient($email, $firstName, $lastName, $password, $gender, $numberPhone, $profession, $age)
    {
        $patient = new Patient();
        $patient->email = $email;
        $patient->firstName = $firstName;
        $patient->lastName = $lastName;
        $patient->gender = $gender;
        $patient->numberPhone = $numberPhone;
        $patient->profession = $profession;
        $patient->age = $age;
        $patient->password = bcrypt($password);
        return $this->nutritionist->patients()->save($patient);
    }

    /**
     * get the number of men and women
     */
    public function countGenderPatient()
    {
        $patients['male'] = $this->nutritionist->patients()->where('gender', 0)->count();
        $patients['female'] = $this->nutritionist->patients()->where('gender', 1)->count();
        return $patients;
    }

    /**
     * get the number of patients by age group
     */

    public function rangeAgePatient()
    {
        $patient = [];
        $data = Config::get('constants.ARRAY_OF_AGE');
        foreach ($data as $age) {
            if($this->rangeAge($age[0], $age[1]) !==0)
            $patient ["[$age[0]-$age[1]]"] = $this->rangeAge($age[0], $age[1]);
            else continue;
        }
        return $patient;
    }

    public function rangeAge($minAge, $maxAge)
    {
        return $this->nutritionist->patients()->where('age', '>=', $minAge)
            ->where('age', '<=', $maxAge)->count();
    }
}
