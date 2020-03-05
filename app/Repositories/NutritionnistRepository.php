<?php


namespace App\Repositories;


use App\Nutritionist;

class NutritionnistRepository
{
    protected $nutritionist;

    /**
     * NutritionnistRepository constructor.
     * @param Nutritionist $nutritionist
     */
    public function __construct(Nutritionist $nutritionist)
    {
        $this->nutritionist = $nutritionist;
    }

    /**
     * Method to get nutritionist  from database
     *
     * @return mixed
     */
    public function getNutritionist()
    {
        return $this->nutritionist;
    }
    /**
     * update nutritionist  from database
     *
     * @return mixed
     */
    public function updateNutritionist($request)
    {
        $this->nutritionist->email = $request['email'] ;
        $this->nutritionist->firstName = $request['firstName'] ;
        $this->nutritionist->lastName = $request['lastName'] ;
        $this->nutritionist->password = bcrypt($request['password']) ;
        $this->nutritionist->picture = bcrypt($request['picture']) ;
        $this->nutritionist->save();
        return  $this->nutritionist;
    }

    /**
     * delete nutritionist  from database
     *
     * @throws \Exception
     */
    public function deleteNutritionist()
    {

        return  $this->nutritionist->delete();
    }
}
