<?php


namespace App\Repositories;

use App\Notification;
use App\Patient;


class NotificationRepository
{

    /**
     * Method to post notification
     * @param Patient $patient
     * @return mixed
     */
    public static function postNotification($patient, $message)
    {
        $notification = new Notification();
        $notification->message = $message;
        $patient->notifications()->save($notification);
        return $notification;
    }

    /**
     * Method to delete notification
     * @param Notification $notification
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public static function deleteNotification($notification)
    {
        return $notification->delete();
    }

}
