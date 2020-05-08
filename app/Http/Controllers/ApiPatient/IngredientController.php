<?php

namespace App\Http\Controllers\ApiPatient;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaginationRequest;
use App\Repositories\PatientRepository;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    /**
     * Method to get all patients related to nutritionist
     *
     * @param PaginationRequest $request
     * @return JsonResponse
     */
    public function index(PaginationRequest $request)
    {
        $page = $request->input('page', 1);
        $perPage = $request->input('perPage', 10);
        $orderBy = $request->input('orderBy', null);
        $orderDirection = $request->input('orderDirection', 'asc');
        $search = $request->input('search', '');
        $patient = auth()->user();

        $patientRepository = new PatientRepository($patient);
        $patients = $patientRepository->paginateIngredient($page, $perPage, $orderBy, $orderDirection, $search);
        return response()->json(['data' => $patients], 200);
    }
}
