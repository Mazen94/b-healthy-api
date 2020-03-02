<?php


namespace App\Repositories;


use App\Nutritionist;


class AuthNutrtionnistRepository
{
    /**
     * @param  $request
     * @return Nutritionist
     */
    public function register( $request)
    {
        $nutritionist = new Nutritionist();
        $nutritionist->email = $request->email;
        $nutritionist->firstName = $request->firstName;
        $nutritionist->lastName = $request->lastName;
        $nutritionist->password = bcrypt($request->password);
        $nutritionist->save();
        return $nutritionist;
    }



}
