<?php

namespace App\Http\Controllers\ApiNutritionnist;

use App\Http\Controllers\Controller;
use App\Repositories\NutritionnistRepository;
use Illuminate\Http\Request;
use JWTAuth;

class NutritionnistController extends Controller
{
    protected $nutritionistRepository;
    protected $nutritionist;
    /**
     * @var NutritionnistRepository
     */


    /**
     * PatientController constructor.
     * @param NutritionnistRepository $nutritionistRepository
     *
     */
    public function __construct(NutritionnistRepository $nutritionistRepository)
    {
        $this->nutritionist = JWTAuth::parseToken()->authenticate();
        $this->nutritionistRepository = new NutritionnistRepository($this->nutritionist);
    }


    /**
     * Display the specified resource.
     *
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $nutritionist = $this->nutritionistRepository->getNutritionist();
        return response()->json(
            [
                'success' => true,
                'nutritionist' => $nutritionist,
            ],
            200
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $nutritionist = $this->nutritionistRepository->updateNutritionist($request);
        return response()->json(
            [
                'success' => true,
                'nutritionist' => $nutritionist,
            ],
            200
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy()
    {
        $this->nutritionistRepository->deleteNutritionist();
        return response()->json(
            [
                'success' => true,
            ],
            200
        );
    }
}
