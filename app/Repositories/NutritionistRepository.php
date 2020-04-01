<?php


namespace App\Repositories;


use App\Ingredient;
use App\MealStore;
use App\Nutritionist;
use App\Patient;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

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
     * @return Nutritionist
     */
    public static function register($email, $firstName, $lastName, $password)
    {
        $nutritionist = new Nutritionist();
        $nutritionist->email = $email;
        $nutritionist->firstName = $firstName;
        $nutritionist->lastName = $lastName;
        $nutritionist->password = bcrypt($password);
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
    public function updateNutritionist($email, $firstName, $lastName, $password, $picture)
    {
        if (!empty($picture)) {
            $this->nutritionist->picture = $picture;
        }
        $this->nutritionist->email = $email;
        $this->nutritionist->firstName = $firstName;
        $this->nutritionist->lastName = $lastName;
        $this->nutritionist->password = bcrypt($password);
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
     * @return LengthAwarePaginator
     */
    public function paginatePatient($page, $perPage, $orderBy, $orderDirection)
    {
        $mealStoreGroups = $this->nutritionist->patients();
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
    public function createPatient($email, $firstName, $lastName, $password, $gender, $numberPhone, $profession)
    {
        $patient = new Patient();
        $patient->email = $email;
        $patient->firstName = $firstName;
        $patient->lastName = $lastName;
        $patient->gender = $gender;
        $patient->numberPhone = $numberPhone;
        $patient->profession = $profession;
        $patient->password = bcrypt($password);
        return $this->nutritionist->patients()->save($patient);
    }
    /**
     * get the number of men and women
     */
    public function countGenderPatient()
    {
        $patients['male'] = $this->nutritionist->patients()->where('gender','male')->count();
        $patients['female']  = $this->nutritionist->patients()->where('gender','female')->count();
        return $patients;
    }

    /**
     * get the number of patients by age group
     */

    public function rangeAgePatient()
    {
        $patients['[10-15]'] = $this->nutritionist->patients()->where('age','>=','10')
            ->where('age','<=','15')->count();
        $patients['[16-20]'] = $this->nutritionist->patients()->where('age','>=','16')
            ->where('age','<=','20')->count();
        $patients['[21-25]'] = $this->nutritionist->patients()->where('age','>=','21')
            ->where('age','<=','25')->count();
        $patients['[26-30]'] = $this->nutritionist->patients()->where('age','>=','26')
            ->where('age','<=','30')->count();
        $patients['[31-35]'] = $this->nutritionist->patients()->where('age','>=','31')
            ->where('age','<=','35')->count();
        $patients['[36-40]'] = $this->nutritionist->patients()->where('age','>=','36')
            ->where('age','<=','40')->count();
        $patients['[41-45]'] = $this->nutritionist->patients()->where('age','>=','41')
            ->where('age','<=','45')->count();
        $patients['[46-50]'] = $this->nutritionist->patients()->where('age','>=','46')
            ->where('age','<=','50')->count();
        $patients['[51-55]'] = $this->nutritionist->patients()->where('age','>=','51')
            ->where('age','<=','55')->count();
        $patients['[56-60]'] = $this->nutritionist->patients()->where('age','>=','56')
            ->where('age','<=','60')->count();
        return $patients;
    }
}
