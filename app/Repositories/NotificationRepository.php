<?php


namespace App\Repositories;

use App\Notification;
use Illuminate\Database\Eloquent\Model;

class NotificationRepository
{
    protected $model;

    /**
     * PatientRepository constructor.
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Method to post notification
     *
     * @return mixed
     */
    public function getNotifications()
    {
        return $this->model->notifications;
    }

    /**
     * Method to post notification
     *
     * @return mixed
     */
    public function postNotification($request)
    {
        $notification = new Notification();
        $notification->message = $request['message'];
        $this->model->notifications()->save($notification);
        return $notification;
    }

    /**
     * Method to delete notification
     *
     * @return mixed
     */
    public function deleteNotification($id)
    {
        $notification = $this->model->notifications()->findOrfail($id);
        return $notification->delete();
    }

    /**
     * Method to get only one notification
     *
     * @return mixed
     */
    public function getNotification($id)
    {
        $notification = $this->model->notifications()->findOrfail($id);
        return $notification;
    }
}
