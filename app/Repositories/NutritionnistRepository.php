<?php


namespace App\Repositories;


use App\Ingredient;
use App\MealStore;
use App\Nutritionist;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class NutritionnistRepository
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
        if (!empty($calorie)) {
            $menu->calorie = $calorie;
        }
        return $this->nutritionist->mealStore()->save($menu);
    }

}
