<?php


namespace App\Repositories;


use App\Nutritionist;
use Illuminate\Http\Request;

class AuthNutrtionnistRepository
{
    /**
     * @param Request $request
     * @return Nutritionist
     */
    public function register(Request $request)
    {
        $nutritionist = new Nutritionist();
        $nutritionist->email = $request->email;
        $nutritionist->firstName = $request->firsName;
        $nutritionist->lastName = $request->firsName;
        $nutritionist->password = bcrypt($request->password);
        $nutritionist->save();
        return $nutritionist;
    }



}
