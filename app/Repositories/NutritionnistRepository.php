<?php


namespace App\Repositories;


use App\Nutritionist;

class NutritionnistRepository
{

    /**
     * @param $email
     * @param $firstName
     * @param $lastName
     * @param $password
     * @return Nutritionist
     */
    public function register($email, $firstName, $lastName, $password)
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
     * @return mixed
     */
    public function updateNutritionist($email, $firstName, $lastName, $password,$picture)
    {
        if(!empty($picture)){
            auth()->user()->picture = $picture;
        }
        auth()->user()->email = $email;
        auth()->user()->firstName = $firstName;
        auth()->user()->lastName = $lastName;
        auth()->user()->password = bcrypt($password);
        auth()->user()->save();
        return auth()->user();
    }

    /**
     * delete nutritionist  from database
     *
     * @throws \Exception
     */
    public function deleteNutritionist()
    {
        return auth()->user()->delete();
    }
}
