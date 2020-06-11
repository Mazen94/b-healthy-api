<?php

namespace App\Http\Controllers\ApiNutritionist;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaginationRequest;
use App\Http\Requests\VisitRequest;
use App\Repositories\PatientRepository;
use App\Repositories\VisitRepository;
use App\Visit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class VisitController extends Controller
{

    /**
     * Method for nutritionist to get all the visits related to a patient from database
     *
     * @param PaginationRequest $request
     * @param int $idPatient
     * @return JsonResponse
     */
    public function index(PaginationRequest $request, $idPatient)
    {
        $nutritionist = auth()->user();
        $patient = $nutritionist->patients()->findOrFail($idPatient);
        $page = $request->input('page', 1);
        $perPage = $request->input('perPage', 10);
        $orderBy = $request->input('orderBy', 'id');
        $orderDirection = $request->input('orderDirection', 'desc');
        $patientRepository = new PatientRepository($patient);
        $visits = $patientRepository->paginateVisits($page, $perPage, $orderBy, $orderDirection);
        return response()->json(['data' => $visits], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param VisitRequest $request
     * @param int $idPatient
     *
     * @return JsonResponse
     */
    public function newMeasure(VisitRequest $request, $idPatient)
    {
        $nutritionist = auth()->user();
        $patient = $nutritionist->patients()->findOrFail($idPatient);
        $visit = [];
        $checkVisit = VisitRepository::checkVisit($idPatient);
        $weight = $request->input('weight');
        $note = $request->input('note');
        $belly = $request->input('belly');
        $chest = $request->input('chest');
        $legs = $request->input('legs');
        $neck = $request->input('neck');
        $tall = $request->input('tall');
        if (!$checkVisit->isEmpty()) {
            $visitRepository = new VisitRepository($checkVisit[0]);
            $visit = $visitRepository->updateVisit(
                $weight,
                $note,
                $belly,
                $chest,
                $legs,
                $neck,
                $tall,
                $checkVisit[0]->scheduledAt,
                $checkVisit[0]->meetingHour
            );
        } else {
            $nutritionist = auth()->user();
            $patient = $nutritionist->patients()->findOrFail($idPatient);
            $patientRepository = new PatientRepository($patient);
            $visit = $patientRepository->createVisit(
                $weight,
                $note,
                $belly,
                $chest,
                $legs,
                $neck,
                $tall,
                null,
                null
            );
        }
        return response()->json(['data' => $visit], 200);
    }

    /**
     * get hour of meeting by date
     * @param Request $request
     * @return mixed
     */
    public function showMeetingHour(Request $request)
    {
        $date = $request->input('date');
        $meetings = VisitRepository::showMeetingByDate($date);
        return response()->json(['data' => $meetings], 200);
    }

    /**
     * create new meeting to the patient
     * @param Request $request
     * @param $idPatient
     * @return mixed
     */
    public function newMeeting(Request $request, $idPatient)
    {
        $visit = [];
        $date = $request->input('date');
        $hour = $request->input('hour');
        $checkVisit = VisitRepository::checkVisit($idPatient);
        if (!$checkVisit->isEmpty()) {
            $visitRepository = new VisitRepository($checkVisit[0]);
            $visit = $visitRepository->updateVisit(
                $checkVisit[0]->weight,
                $checkVisit[0]->note,
                $checkVisit[0]->belly,
                $checkVisit[0]->chest,
                $checkVisit[0]->legs,
                $checkVisit[0]->neck,
                $checkVisit[0]->tall,
                $date,
                $hour
            );
        } else {
            $nutritionist = auth()->user();
            $patient = $nutritionist->patients()->findOrFail($idPatient);
            $patientRepository = new PatientRepository($patient);
            $visit = $patientRepository->createVisit(
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                $date,
                $hour
            );
        }
        return response()->json(['data' => $visit], 200);
    }


    /**
     * get meeting of day
     *
     * @return mixed
     */
    public function showMeetingOfDay()
    {
        $meetingOfDay = [];
        $nutritionist = auth()->user();
        $patients = $nutritionist->patients;
        foreach ($patients as $patient) {
            $meetingHour = VisitRepository::checkMeetingDayById($patient->id);
            if (!$meetingHour->isEmpty()) {
                $data = [];
                $data['photo'] = $patient->photo;
                $data['firstName'] = $patient->firstName;
                $data['lastName'] = $patient->lastName;
                $data['meetingHour'] = $meetingHour[0]->meetingHour;
                $data['idVisit'] = $meetingHour[0]->id;
                $data['idPatient'] = $patient->id;
                $meetingOfDay = $array = Arr::collapse(

                    [$meetingOfDay, [$data]]
                );
            }
        }
        $meetingOfDay = collect($meetingOfDay)->sortBy('meetingHour');
        //the values method to reset the keys to consecutively numbered indexes
        return response()->json(['data' => $meetingOfDay->values()->all()], 200);
    }

    /**
     * get hour of meeting by date
     * @param Request $request
     * @return mixed
     */
    public function deleteMeeting(Request $request)
    {
        $id = $request->input('id');
        $visit = Visit::findOrFail($id);
        VisitRepository::deleteMeeting($visit);
        return response()->json(['data' => true], 200);
    }
}
