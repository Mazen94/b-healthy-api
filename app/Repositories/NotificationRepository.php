<?php


namespace App\Repositories;

use App\Notification;
use Illuminate\Database\Eloquent\Model;


class NotificationRepository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }


    /**
     * Method to post notification
     *
     * @param String $message
     *
     * @return mixed
     */
    public function postNotification($message)
    {
        $notification = new Notification();
        $notification->message = $message;
        $this->model->notifications()->save($notification);
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
    public function deleteNotification()
    {
        return $this->model->delete();
    }

}
