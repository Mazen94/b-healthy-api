<?php

namespace App\Http\Controllers\ApiPatient;

use App\Http\Controllers\Controller;
use App\Http\Requests\NotificationRequest;
use App\Repositories\NotificationRepository;
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
        return response()->json(
            [
                'response' => 'success',
                'Notifications' => $notification,
            ]
        );
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
        $notification = NotificationRepository::postNotification($patient, $request->input('message'));
        return response()->json(
            [
                'response' => 'success',
                'Notification' => $notification,
            ]
        );
    }

    /**
     * Method to create only one notification related to patient
     *
     * @return JsonResponse
     */
    public function show($id)
    {
        $patient = auth()->user();
        $notification = $patient->notifications()->findOrfail($id);
        return response()->json(
            [
                'response' => 'success',
                'Notifications' => $notification,

            ]
        );
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
        NotificationRepository::deleteNotification($notification);
        return response()->json(
            [
                'response' => 'success',

            ]
        );
    }
}
