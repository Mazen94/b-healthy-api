<?php

namespace App\Http\Controllers\ApiPatient;

use App\Http\Controllers\Controller;
use App\Http\Requests\NotificationRequest;
use App\Repositories\NotificationRepository;
use JWTAuth;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $patient = auth()->user();
        $notificationRepository = new NotificationRepository($patient);
        $notification = $notificationRepository->getNotifications();
        return response()->json(
            [
                'response' => 'success',
                'Notifications' => $notification,

            ]
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(NotificationRequest $request)
    {
        $patient = JWTAuth::parseToken()->authenticate();
        $notificationRepository = new NotificationRepository($patient);
        $notification = $notificationRepository->postNotification($request);
        return response()->json(
            [
                'response' => 'success',
                'Notifications' => $notification,

            ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $patient = JWTAuth::parseToken()->authenticate();
        $notificationRepository = new NotificationRepository($patient);
        $notification = $notificationRepository->getNotification($id);
        return response()->json(
            [
                'response' => 'success',
                'Notifications' => $notification,

            ]
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $patient = JWTAuth::parseToken()->authenticate();
        $notificationRepository = new NotificationRepository($patient);
        $notificationRepository->deleteNotification($id);
        return response()->json(
            [
                'response' => 'success',

            ]
        );
    }
}
