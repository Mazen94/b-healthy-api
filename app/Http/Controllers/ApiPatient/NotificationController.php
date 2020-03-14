<?php

namespace App\Http\Controllers\ApiPatient;

use App\Http\Controllers\Controller;
use App\Http\Requests\NotificationRequest;
use App\Repositories\NotificationRepository;
use App\Repositories\PatientRepository;
use Illuminate\Http\JsonResponse;


class NotificationController extends Controller
{
    /**
     * Method to get all the notifications related to patient
     *
     * @return JsonResponse
     */
    public function index()
    {
        $patient = auth()->user();
        $notification = $patient->notifications;
        return response()->json(['Notifications' => $notification], 200);
    }

    /**
     * Method to create new notification related to patient
     * @param NotificationRequest $request
     *
     * @return JsonResponse
     */
    public function store(NotificationRequest $request)
    {
        $patient = auth()->user();
        $message = $request->input('message');
        $patientRepository = new PatientRepository($patient);
        $patient = $patientRepository->postNotification($message);
        return response()->json(['Notification' => $patient], 200);
    }

    /**
     * Method to create only one notification related to patient
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $patient = auth()->user();
        $notification = $patient->notifications()->findOrfail($id);
        return response()->json(['Notifications' => $notification], 200);
    }

    /**
     * Method to delete notification related to patient
     * @param int $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $patient = auth()->user();
        $notification = $patient->notifications()->findOrfail($id);
        $notificationRepository = new NotificationRepository($notification);
        $notificationRepository->deleteNotification();
        return response()->json(['response' => 'success'], 200);
    }
}
