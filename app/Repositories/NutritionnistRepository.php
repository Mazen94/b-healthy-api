<?php


namespace App\Repositories;


use App\Nutritionist;

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
}
